<?php

/**
 * libphonenumber-for-php data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

declare(strict_types=1);

namespace libphonenumber\data;

use libphonenumber\NumberFormat;
use libphonenumber\PhoneMetadata;
use libphonenumber\PhoneNumberDesc;

/**
 * @internal
 */
class PhoneNumberMetadata_LB extends PhoneMetadata
{
    protected const ID = 'LB';
    protected const COUNTRY_CODE = 961;
    protected const NATIONAL_PREFIX = '0';

    protected ?string $nationalPrefixForParsing = '0';
    protected ?string $internationalPrefix = '00';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[27-9]\d{7}|[13-9]\d{6}')
            ->setPossibleLength([7, 8]);
        $this->mobile = (new PhoneNumberDesc())
            ->setNationalNumberPattern('(?:(?:3|81)\d|7(?:[01]\d|6[013-9]|8[7-9]|9[1-3]))\d{5}')
            ->setExampleNumber('71123456');
        $this->premiumRate = (new PhoneNumberDesc())
            ->setNationalNumberPattern('9[01]\d{6}')
            ->setExampleNumber('90123456')
            ->setPossibleLength([8]);
        $this->fixedLine = (new PhoneNumberDesc())
            ->setNationalNumberPattern('7(?:62|8[0-6]|9[04-9])\d{4}|(?:[14-69]\d|2(?:[14-69]\d|[78][1-9])|7[2-57]|8[02-9])\d{5}')
            ->setExampleNumber('1123456');
        $this->numberFormat = [
            (new NumberFormat())
                ->setPattern('(\d)(\d{3})(\d{3})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['[13-69]|7(?:[2-57]|62|8[0-6]|9[04-9])|8[02-9]'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{2})(\d{3})(\d{3})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['[27-9]'])
                ->setNationalPrefixOptionalWhenFormatting(false),
        ];
        $this->tollFree = PhoneNumberDesc::empty();
        $this->sharedCost = (new PhoneNumberDesc())
            ->setNationalNumberPattern('80\d{6}')
            ->setExampleNumber('80123456')
            ->setPossibleLength([8]);
        $this->personalNumber = PhoneNumberDesc::empty();
        $this->voip = PhoneNumberDesc::empty();
        $this->pager = PhoneNumberDesc::empty();
        $this->uan = PhoneNumberDesc::empty();
        $this->voicemail = PhoneNumberDesc::empty();
        $this->noInternationalDialling = PhoneNumberDesc::empty();
    }
}
