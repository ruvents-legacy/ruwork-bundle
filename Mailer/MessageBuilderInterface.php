<?php

namespace Ruwork\CoreBundle\Mailer;

interface MessageBuilderInterface
{
    public function setFrom(MailUserInterface $from): MessageBuilderInterface;

    public function setSubjects(array $subjects): MessageBuilderInterface;

    public function addSubject(string $subject, string $locale = null): MessageBuilderInterface;

    public function setTemplates(array $templates): MessageBuilderInterface;

    public function addTemplate(string $template, string $locale = null): MessageBuilderInterface;

    public function setParameters(array $parameters): MessageBuilderInterface;

    public function addParameter(string $name, $value): MessageBuilderInterface;

    public function setContentType(string $contentType): MessageBuilderInterface;

    public function getMessage(MailUserInterface $to): \Swift_Mime_SimpleMessage;

    public function sendTo(MailUserInterface $to): MessageBuilderInterface;
}
