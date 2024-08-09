<?php


/**
 * Translate utils base to i18n laravel implementation
 * Use for auto add unknow tralatable text on
 * @param string $k Original text
 * @return string Transalted text
 */
function t(string $k): string
{
    if (App::hasDebugModeEnabled()) {
        $local = App::getLocale();
        $tradString = file_get_contents(__DIR__ . '/../../lang/' . $local . '.json');
        $trad = json_decode($tradString, true);
        if (!isset($trad[$k])) {
            if (!empty($k)) {
                $trad[$k] = trim($k);
            }
            file_put_contents(__DIR__ . '/../../lang/' . $local . '.json', json_encode($trad, JSON_PRETTY_PRINT));
        }

    }

    return trans(trim($k));
}
