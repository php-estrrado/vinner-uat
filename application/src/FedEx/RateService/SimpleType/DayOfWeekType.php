<?php
namespace FedEx\RateService\SimpleType;

use FedEx\AbstractSimpleType;

/**
 * DayOfWeekType
 *
 * @author      Jeremy Dunn <jeremy@jsdunn.info>
 * @package     PHP FedEx API wrapper
 * @subpackage  Rate Service
 */
class DayOfWeekType
    extends AbstractSimpleType
{
    const _FRI = 'FRI';
    const _MON = 'MON';
    const _SAT = 'SAT';
    const _SUN = 'SUN';
    const _THU = 'THU';
    const _TUE = 'TUE';
    const _WED = 'WED';
}