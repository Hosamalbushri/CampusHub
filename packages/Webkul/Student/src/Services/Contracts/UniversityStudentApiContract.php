<?php

namespace Webkul\Student\Services\Contracts;

use Webkul\Student\DataTransferObjects\StudentProfileDto;

interface UniversityStudentApiContract
{
    /**
     * Verify credentials with the university and return profile data on success.
     *
     * @throws \Webkul\Student\Services\Exceptions\UniversityApiException
     */
    public function verifyAndFetchProfile(string $universityCardNumber, string $password): StudentProfileDto;
}
