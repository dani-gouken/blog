<?php
/**
 * @var $metadata ClassMetadata
 */

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\MappingException;

/**
 * @param ClassMetadata $metadata
 * @throws MappingException
 */
(function(ClassMetadata $metadata)
{
    $metadata->setPrimaryTable([
        "name" => "posts",
    ]);
    $metadata->mapField(array(
        'id' => true,
        'fieldName' => 'id',
        'type' => 'integer',
        "options" => [
            "unique" => true
        ]
    ));
    $metadata->setIdentifier(["id"]);
    $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_AUTO);
    $metadata->mapField(array(
        'fieldName' => 'title',
        'type' => 'string',
    ));

    $metadata->mapField(array(
        'fieldName' => 'content',
        'type' => 'text',
    ));

    $metadata->mapField(array(
        'fieldName' => 'createdAt',
        'type' => 'datetime',
        "options" => [
            "default" => "CURRENT_TIMESTAMP"
        ]
    ));

    $metadata->mapField(array(
        'fieldName' => 'updatedAt',
        'type' => 'datetime',
        "nullable" => true
    ));
})($metadata);

