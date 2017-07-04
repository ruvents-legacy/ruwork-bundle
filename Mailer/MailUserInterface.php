<?php

namespace Ruvents\RuworkBundle\Mailer;

interface MailUserInterface
{
    public function getEmail(): string;

    public function getMailName(string $locale): string;

    public function getMailLocale(): string;
}
