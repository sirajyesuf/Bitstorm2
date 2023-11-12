<?php

if (!function_exists('identifyPhoneOrEmail')) {
    function identifyPhoneOrEmail($input)
    {
        // Check if the input matches the pattern of an email address
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }

        // Check if the input matches the pattern of a phone number
        // This is a basic example and may not cover all possible phone number formats
        $phonePattern = '/^\+?\d{1,4}?[-.\s]?\(?\d{1,4}\)?[-.\s]?\d{1,9}[-.\s]?\d{1,9}$/';
        if (preg_match($phonePattern, $input)) {
            return 'phone';
        }

        // If the input doesn't match email or phone number patterns, return null or handle accordingly
        return null;
    }
}
