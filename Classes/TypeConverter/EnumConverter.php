<?php

declare(strict_types=1);

namespace AUS\ExtbaseEnumConverter\TypeConverter;

use TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationInterface;
use TYPO3\CMS\Extbase\Property\TypeConverterInterface;

class EnumConverter implements TypeConverterInterface
{
    public function getSupportedSourceTypes(): array
    {
        return ['string', 'integer', 'float'];
    }

    public function getSupportedTargetType(): string
    {
        return 'object';
    }

    public function getTargetTypeForSource($source, string $originalTargetType, PropertyMappingConfigurationInterface $configuration = null): string
    {
        return $originalTargetType;
    }

    public function getPriority(): int
    {
        return 100_000_000;
    }

    public function canConvertFrom($source, string $targetType): bool
    {
        return enum_exists($targetType) && $this->getEnumElement($source, $targetType);
    }

    /**
     * @return mixed[]
     */
    public function getSourceChildPropertiesToBeConverted($source): array
    {
        return [];
    }

    public function getTypeOfChildProperty(string $targetType, string $propertyName, PropertyMappingConfigurationInterface $configuration): string
    {
        return '';
    }

    /**
     * @param $source
     * @param string $targetType
     * @param mixed[] $convertedChildProperties
     * @param PropertyMappingConfigurationInterface|null $configuration
     * @return mixed
     */
    public function convertFrom($source, string $targetType, array $convertedChildProperties = [], PropertyMappingConfigurationInterface $configuration = null): mixed
    {
        return $this->getEnumElement($source, $targetType);
    }

    private function getEnumElement(mixed $source, string $targetType): mixed
    {
        foreach ($targetType::cases() as $enum) {
            if ($enum->name == $source) {
                return $enum;
            }
        }
        foreach ($targetType::cases() as $enum) {
            if (!property_exists($enum, 'value')) {
                continue;
            }
            if ($enum->value != $source) {
                continue;
            }
            return $enum;
        }
        return null;
    }
}
