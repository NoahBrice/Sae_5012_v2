<?php
// api/src/Serializer/UploadedFileDenormalizer.php

namespace App\Serializer;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class UploadedFileDenormalizer implements DenormalizerInterface
{
    public function denormalize($data, string $type, string $format = null, array $context = []): UploadedFile
    {
        return $data;
    }

    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return $data instanceof UploadedFile;
    }
}