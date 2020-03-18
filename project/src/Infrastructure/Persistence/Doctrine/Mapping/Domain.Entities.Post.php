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
        "name" => "posts"
    ]);
    $metadata->mapField(array(
        'id' => true,
        'fieldName' => 'id',
        'type' => 'integer'
    ));
    $metadata->mapField(array(
        'fieldName' => 'title',
        'type' => 'string',
    ));

    $metadata->mapField(array(
        'fieldName' => 'content',
        'type' => 'text',
    ));

    $metadata->mapField(array(
        'fieldName' => 'created_at',
        'type' => 'date',
    ));

    $metadata->mapField(array(
        'fieldName' => 'updated_at',
        'type' => 'date',
    ));
})();

