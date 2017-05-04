<?php

namespace Ruwork\CoreBundle\Serializer\Encoder;

use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

class ExcelCsvEncoder implements EncoderInterface
{
    const FORMAT = 'excel_csv';

    /**
     * @var CsvEncoder
     */
    private $csvEncoder;

    /**
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escapeChar
     * @param string $keySeparator
     */
    public function __construct($delimiter = ';', $enclosure = '"', $escapeChar = '\\', $keySeparator = '.')
    {
        $this->csvEncoder = new CsvEncoder($delimiter, $enclosure, $escapeChar, $keySeparator);
    }

    /**
     * {@inheritdoc}
     */
    public function encode($data, $format, array $context = [])
    {
        return "\xEF\xBB\xBF".$this->csvEncoder->encode($data, $format, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsEncoding($format)
    {
        return self::FORMAT === $format;
    }
}
