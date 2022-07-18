<?php

class Formulary
{
    private array $errors = [];

    public function validateForm(array $form): array
    {
        $inputs = ['name', "payment"];
        foreach ($form as $input => $inputValue) {
            if (!in_array($input, $inputs)) {
                $this->errors[] = 'Eh eh the field ' . $input . ' does not exist';
            } elseif (empty($inputValue)) {
                $this->errors[] = 'The field ' . $input . ' must not be empty';
            } elseif ($input === 'payment' && !empty($inputValue) && $inputValue <= 0) {
                $this->errors[] = 'Payment must be greater than 0';
            }
        }
        if ($form['name'] === 'Eliott Ness') {
            $this->errors[] = 'This man is untouchable';
        }
        return $this->errors;
    }

    public function validateLetter(string $letter): bool
    {
        if (!in_array($letter, range('A', 'Z'))) {
            header('location: /book.php');
            exit('The search must be a letter');
        }
        return false;
    }
}
