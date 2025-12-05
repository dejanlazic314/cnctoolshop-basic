<?php

namespace Cnctoolshop\EventListener;

use Contao\Form;
use Contao\Email;
use Contao\Config;

class ProcessFormDataListener
{
    public function __invoke(
        array &$submittedData,
        array $labels,
        array $fields,
        Form $form,
        array &$files
    ): void {

        $formId = (string) ($form->formID ?? '');

        if ($formId === '' || !str_starts_with($formId, 'cnc-')) {
            return;
        }

        // Basic sanity check for inquiry forms
        $hasEmail = !empty($submittedData['email']);
        $hasMsg   = !empty($submittedData['poruka']);
        $hasName  = !empty($submittedData['imePrezime']) || !empty($submittedData['ime_i_prezime']);

        if (!($hasEmail && $hasMsg && $hasName)) {
            return;
        }

        // Detect language from Contao runtime
        $lang = (string) ($GLOBALS['TL_LANGUAGE'] ?? 'sr');
        $isEn = str_starts_with($lang, 'en');

        // -------------------------
        // 1) ADMIN EMAIL
        // -------------------------
        $fullName =
            $submittedData['imePrezime']
            ?? $submittedData['ime_i_prezime']
            ?? 'Unknown';

        $adminMail = new Email();
        $adminMail->subject = ($isEn ? 'New website inquiry - ' : 'Nova poruka sa sajta - ') . $fullName;
        $adminMail->from = (string) Config::get('adminEmail');
        $adminMail->html = $this->getAdminEmailTemplate($submittedData, $labels, $isEn);

        // Attach uploaded files (Contao Email uses attachFile)
        $this->attachUploadedFiles($adminMail, $files);

        $recipient = trim((string) ($form->recipient ?? ''));
        if ($recipient === '') {
            $recipient = (string) Config::get('adminEmail');
        }

        $adminMail->sendTo($recipient);

        // -------------------------
        // 2) USER CONFIRMATION EMAIL
        // -------------------------
        $userEmail = trim((string) ($submittedData['email'] ?? ''));

        if ($userEmail !== '') {
            $userMail = new Email();
            $userMail->subject = $isEn ? 'Thank you for your inquiry - CNC Toolshop'
                                       : 'Hvala na upitu - CNC Toolshop';
            $userMail->from = (string) Config::get('adminEmail');
            $userMail->html = $isEn
                ? $this->getUserConfirmationTemplateEn($submittedData)
                : $this->getUserConfirmationTemplateSr($submittedData);

            $userMail->sendTo($userEmail);
        }

        // Disable default Contao sending
        $form->sendViaEmail = false;
    }

    private function attachUploadedFiles(Email $mail, array $files): void
    {
        if (empty($files)) {
            return;
        }

        foreach ($files as $fieldName => $fileList) {
            if (empty($fileList)) {
                continue;
            }

            if (!is_array($fileList)) {
                $fileList = [$fileList];
            }

            foreach ($fileList as $file) {
                // Most common: string path
                if (is_string($file) && is_file($file)) {
                    $mail->attachFile($file);
                    continue;
                }

                // Alternative: array with tmp_name/name
                if (is_array($file)) {
                    $tmp  = $file['tmp_name'] ?? null;
                    $name = $file['name'] ?? null;

                    if ($tmp && is_file($tmp)) {
                        $mail->attachFile($tmp, $name);
                    }
                }
            }
        }
    }

    private function getAdminEmailTemplate(array $data, array $labels, bool $isEn): string
    {
        $rows = '';

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = implode(', ', $value);
            }

            $label = $labels[$key] ?? ucfirst(str_replace('_', ' ', (string) $key));

            $rows .= '<tr>
                <td style="background-color: #f8f9fa; padding: 12px 16px; border-bottom: 1px solid #e0e0e0; width: 35%; vertical-align: top;">
                    <strong style="color: #2d2d2d; font-size: 14px;">' . htmlspecialchars((string) $label) . '</strong>
                </td>
                <td style="padding: 12px 16px; border-bottom: 1px solid #e0e0e0; color: #444444; font-size: 14px; vertical-align: top;">
                    ' . nl2br(htmlspecialchars((string) $value)) . '
                </td>
            </tr>';
        }

        $date = (new \DateTimeImmutable('now', new \DateTimeZone('Europe/Belgrade')))
            ->format('d.m.Y H:i:s');

        $title = $isEn ? 'New website inquiry' : 'Nova poruka sa sajta';
        $intro = $isEn ? 'You have received a new message via the form:' : 'Primili ste novu poruku putem kontakt forme:';

        return '<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">
<table width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f4f4;">
<tr><td style="padding: 40px 20px;">
<table width="600" cellspacing="0" cellpadding="0" align="center" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

    <tr>
        <td style="background-color: #020a0f; padding: 30px 40px; text-align: center;">
            <img src="https://cnctoolshop.rs/files/Images/logo.png" alt="CNC Toolshop" width="200">
        </td>
    </tr>

    <tr>
        <td style="background-color: #23597b; padding: 20px 40px;">
            <h1 style="margin: 0; color: #ffffff; font-size: 22px;">📩 ' . $title . '</h1>
        </td>
    </tr>

    <tr>
        <td style="padding: 30px 40px;">
            <p style="margin: 0 0 20px; color: #666; font-size: 14px;">' . $intro . '</p>
            <table width="100%" cellspacing="0" cellpadding="0" style="border: 1px solid #e0e0e0; border-radius: 6px; overflow: hidden;">
                ' . $rows . '
            </table>
            <p style="margin: 25px 0 0; color: #999; font-size: 12px;">📅 ' . $date . '</p>
        </td>
    </tr>

    <tr>
        <td style="background-color: #f8f9fa; padding: 15px 40px; text-align: center; border-top: 1px solid #e0e0e0;">
            <p style="margin: 0; color: #999; font-size: 11px;">Automated message from cnctoolshop.rs</p>
        </td>
    </tr>

</table>
</td></tr>
</table>
</body>
</html>';
    }

    private function getUserConfirmationTemplateSr(array $data): string
    {
        $name =
            $data['imePrezime']
            ?? $data['ime_i_prezime']
            ?? 'Poštovani';

        return '<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">
<table width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f4f4;">
<tr><td style="padding: 40px 20px;">
<table width="600" cellspacing="0" cellpadding="0" align="center" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

    <tr>
        <td style="background-color: #020a0f; padding: 30px 40px; text-align: center;">
            <img src="https://cnctoolshop.rs/files/Images/logo.png" alt="CNC Toolshop" width="200">
        </td>
    </tr>

    <tr>
        <td style="background-color: #23597b; padding: 30px 40px; text-align: center;">
            <div style="width: 50px; height: 50px; background-color: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 15px; line-height: 50px; font-size: 24px;">✓</div>
            <h1 style="margin: 0; color: #ffffff; font-size: 24px;">Hvala vam na upitu!</h1>
        </td>
    </tr>

    <tr>
        <td style="padding: 35px 40px;">
            <p style="margin: 0 0 15px; color: #2d2d2d; font-size: 16px;">Poštovani/a? ,</p>
            <p style="margin: 0 0 20px; color: #444; font-size: 15px; line-height: 1.6;">
                Vaš upit je uspešno primljen. Naš tim će pregledati vašu poruku i odgovoriti vam u najkraćem mogućem roku, obično u roku od <strong>24 sata</strong>.
            </p>

            <div style="background-color: #f8f9fa; padding: 20px; border-left: 4px solid #23597b; margin: 25px 0;">
                <p style="margin: 0 0 10px; color: #2d2d2d; font-weight: bold; font-size: 14px;">Kontakt informacije:</p>
                <p style="margin: 5px 0; color: #444; font-size: 14px;">📧 info@cnctoolshop.rs</p>
                <p style="margin: 5px 0; color: #444; font-size: 14px;">📞 +381 64 123 4567</p>
            </div>

            <p style="text-align: center; margin: 30px 0 0;">
                <a href="https://cnctoolshop.rs" style="display: inline-block; background-color: #23597b; color: #ffffff; text-decoration: none; padding: 12px 30px; border-radius: 6px; font-size: 14px; font-weight: bold;">
                    Posetite naš sajt
                </a>
            </p>
        </td>
    </tr>

    <tr>
        <td style="background-color: #020a0f; padding: 25px 40px; text-align: center;">
            <p style="margin: 0 0 5px; color: #ffffff; font-size: 14px; font-weight: bold;">CNC Toolshop</p>
            <p style="margin: 0; color: #888; font-size: 12px;">© ' . date('Y') . ' Sva prava zadržana</p>
        </td>
    </tr>

</table>
</td></tr>
</table>
</body>
</html>';
    }

    private function getUserConfirmationTemplateEn(array $data): string
    {
        $name =
            $data['imePrezime']
            ?? $data['ime_i_prezime']
            ?? 'Hello';

        return '<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">
<table width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f4f4;">
<tr><td style="padding: 40px 20px;">
<table width="600" cellspacing="0" cellpadding="0" align="center" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

    <tr>
        <td style="background-color: #020a0f; padding: 30px 40px; text-align: center;">
            <img src="https://cnctoolshop.rs/files/Images/logo.png" alt="CNC Toolshop" width="200">
        </td>
    </tr>

    <tr>
        <td style="background-color: #23597b; padding: 30px 40px; text-align: center;">
            <div style="width: 50px; height: 50px; background-color: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 15px; line-height: 50px; font-size: 24px;">✓</div>
            <h1 style="margin: 0; color: #ffffff; font-size: 24px;">Thank you for your inquiry!</h1>
        </td>
    </tr>

    <tr>
        <td style="padding: 35px 40px;">
            <p style="margin: 0 0 15px; color: #2d2d2d; font-size: 16px;">Dear Customer,</p>
            <p style="margin: 0 0 20px; color: #444; font-size: 15px; line-height: 1.6;">
                We have received your message. Our team will review it and get back to you as soon as possible, usually within <strong>24 hours</strong>.
            </p>

            <div style="background-color: #f8f9fa; padding: 20px; border-left: 4px solid #23597b; margin: 25px 0;">
                <p style="margin: 0 0 10px; color: #2d2d2d; font-weight: bold; font-size: 14px;">Contact:</p>
                <p style="margin: 5px 0; color: #444; font-size: 14px;">📧 info@cnctoolshop.rs</p>
                <p style="margin: 5px 0; color: #444; font-size: 14px;">📞 +381 64 123 4567</p>
            </div>

            <p style="text-align: center; margin: 30px 0 0;">
                <a href="https://cnctoolshop.rs" style="display: inline-block; background-color: #23597b; color: #ffffff; text-decoration: none; padding: 12px 30px; border-radius: 6px; font-size: 14px; font-weight: bold;">
                    Visit our website
                </a>
            </p>
        </td>
    </tr>

    <tr>
        <td style="background-color: #020a0f; padding: 25px 40px; text-align: center;">
            <p style="margin: 0 0 5px; color: #ffffff; font-size: 14px; font-weight: bold;">CNC Toolshop</p>
            <p style="margin: 0; color: #888; font-size: 12px;">© ' . date('Y') . ' All rights reserved</p>
        </td>
    </tr>

</table>
</td></tr>
</table>
</body>
</html>';
    }
}
