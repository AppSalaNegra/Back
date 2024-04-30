<?php

namespace Hydrators;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Hydrator\HydratorException;
use Doctrine\ODM\MongoDB\Hydrator\HydratorInterface;
use Doctrine\ODM\MongoDB\Query\Query;
use Doctrine\ODM\MongoDB\UnitOfWork;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ODM. DO NOT EDIT THIS FILE.
 */
class AppEventsDomainEventHydrator implements HydratorInterface
{
    private $dm;
    private $unitOfWork;
    private $class;

    public function __construct(DocumentManager $dm, UnitOfWork $uow, ClassMetadata $class)
    {
        $this->dm = $dm;
        $this->unitOfWork = $uow;
        $this->class = $class;
    }

    public function hydrate(object $document, array $data, array $hints = array()): array
    {
        $hydratedData = array();

        /** @Field(type="id") */
        if (isset($data['_id']) || (! empty($this->class->fieldMappings['id']['nullable']) && array_key_exists('_id', $data))) {
            $value = $data['_id'];
            if ($value !== null) {
                $typeIdentifier = $this->class->fieldMappings['id']['type'];
                $return = $value instanceof \MongoDB\BSON\ObjectId ? (string) $value : $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['id']->setValue($document, $return);
            $hydratedData['id'] = $return;
        }

        /** @Field(type="date") */
        if (isset($data['startDateTime'])) {
            $value = $data['startDateTime'];
            if ($value === null) { $return = null; } else { $return = \Doctrine\ODM\MongoDB\Types\DateType::getDateTime($value); }
            $this->class->reflFields['startDateTime']->setValue($document, clone $return);
            $hydratedData['startDateTime'] = $return;
        }

        /** @Field(type="date") */
        if (isset($data['finishDateTime'])) {
            $value = $data['finishDateTime'];
            if ($value === null) { $return = null; } else { $return = \Doctrine\ODM\MongoDB\Types\DateType::getDateTime($value); }
            $this->class->reflFields['finishDateTime']->setValue($document, clone $return);
            $hydratedData['finishDateTime'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['title']) || (! empty($this->class->fieldMappings['title']['nullable']) && array_key_exists('title', $data))) {
            $value = $data['title'];
            if ($value !== null) {
                $typeIdentifier = $this->class->fieldMappings['title']['type'];
                $return = (string) $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['title']->setValue($document, $return);
            $hydratedData['title'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['excerpt']) || (! empty($this->class->fieldMappings['excerpt']['nullable']) && array_key_exists('excerpt', $data))) {
            $value = $data['excerpt'];
            if ($value !== null) {
                $typeIdentifier = $this->class->fieldMappings['excerpt']['type'];
                $return = (string) $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['excerpt']->setValue($document, $return);
            $hydratedData['excerpt'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['url']) || (! empty($this->class->fieldMappings['url']['nullable']) && array_key_exists('url', $data))) {
            $value = $data['url'];
            if ($value !== null) {
                $typeIdentifier = $this->class->fieldMappings['url']['type'];
                $return = (string) $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['url']->setValue($document, $return);
            $hydratedData['url'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['slug']) || (! empty($this->class->fieldMappings['slug']['nullable']) && array_key_exists('slug', $data))) {
            $value = $data['slug'];
            if ($value !== null) {
                $typeIdentifier = $this->class->fieldMappings['slug']['type'];
                $return = (string) $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['slug']->setValue($document, $return);
            $hydratedData['slug'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['thumbnail_url']) || (! empty($this->class->fieldMappings['thumbnail_url']['nullable']) && array_key_exists('thumbnail_url', $data))) {
            $value = $data['thumbnail_url'];
            if ($value !== null) {
                $typeIdentifier = $this->class->fieldMappings['thumbnail_url']['type'];
                $return = (string) $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['thumbnail_url']->setValue($document, $return);
            $hydratedData['thumbnail_url'] = $return;
        }

        /** @Field(type="collection") */
        if (isset($data['cats']) || (! empty($this->class->fieldMappings['cats']['nullable']) && array_key_exists('cats', $data))) {
            $value = $data['cats'];
            if ($value !== null) {
                $typeIdentifier = $this->class->fieldMappings['cats']['type'];
                $return = $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['cats']->setValue($document, $return);
            $hydratedData['cats'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['status']) || (! empty($this->class->fieldMappings['status']['nullable']) && array_key_exists('status', $data))) {
            $value = $data['status'];
            if ($value !== null) {
                $typeIdentifier = $this->class->fieldMappings['status']['type'];
                $return = (string) $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['status']->setValue($document, $return);
            $hydratedData['status'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['hierarchy']) || (! empty($this->class->fieldMappings['hierarchy']['nullable']) && array_key_exists('hierarchy', $data))) {
            $value = $data['hierarchy'];
            if ($value !== null) {
                $typeIdentifier = $this->class->fieldMappings['hierarchy']['type'];
                $return = (string) $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['hierarchy']->setValue($document, $return);
            $hydratedData['hierarchy'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['type']) || (! empty($this->class->fieldMappings['type']['nullable']) && array_key_exists('type', $data))) {
            $value = $data['type'];
            if ($value !== null) {
                $typeIdentifier = $this->class->fieldMappings['type']['type'];
                $return = (string) $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['type']->setValue($document, $return);
            $hydratedData['type'] = $return;
        }
        return $hydratedData;
    }
}