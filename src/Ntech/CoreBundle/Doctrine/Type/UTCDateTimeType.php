<?php
namespace Ntech\CoreBundle\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeType;
use DateTime;
use DateTimeZone;

class UTCDateTimeType extends DateTimeType
{
    static private $utc;

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $zone = new DateTimeZone('UTC');
        if($value instanceof DateTime && $value->getTimezone()->getName() !== 'UTC')
            $value->setTimezone($value);

        return parent::convertToDatabaseValue($value, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if(null === $value || $value instanceof \DateTime) {
            return $value;
        }

        $converted = \DateTime::createFromFormat(
            $platform->getDateTimeFormatString(),
            $value,
            self::$utc ? self::$utc : self::$utc = new \DateTimeZone('UTC')
        );

        if(!$converted) {
            throw ConversionException::conversionFailedFormat(
                $value,
                $this->getName(),
                $platform->getDateTimeFormatString()
            );
        }

        return $converted;
    }
}