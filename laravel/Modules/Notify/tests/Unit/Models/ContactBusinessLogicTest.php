<?php

declare(strict_types=1);

uses(\Modules\Notify\Tests\TestCase::class);

use Modules\Notify\Models\BaseModel;
use Modules\Notify\Models\Contact;

describe('Contact Business Logic', function () {
    test('contact extends base model', function () {
        expect(Contact::class)->toBeSubclassOf(BaseModel::class);
    });

    test('contact can store polymorphic model relationships', function () {
<<<<<<< HEAD
        $contact = new Contact;
=======
        $contact = new Contact();
>>>>>>> ac0ea089 (.)
        $contact->model_type = 'App\\Models\\User';
        $contact->model_id = '1';

        expect($contact->model_type)->toBe('App\\Models\\User');
        expect($contact->model_id)->toBe('1');
    });

    test('contact can store contact information with type', function () {
<<<<<<< HEAD
        $contact = new Contact;
=======
        $contact = new Contact();
>>>>>>> ac0ea089 (.)
        $contact->contact_type = 'email';
        $contact->value = 'test@example.com';

        expect($contact->contact_type)->toBe('email');
        expect($contact->value)->toBe('test@example.com');
    });

    test('contact can track sms communication', function () {
<<<<<<< HEAD
        $contact = new Contact;
=======
        $contact = new Contact();
>>>>>>> ac0ea089 (.)
        $contact->sms_count = 5;
        $contact->sms_status_code = '200';
        $contact->sms_status_txt = 'Success';

        expect($contact->sms_count)->toBe(5);
        expect($contact->sms_status_code)->toBe('200');
        expect($contact->sms_status_txt)->toBe('Success');
    });

    test('contact can track email communication', function () {
<<<<<<< HEAD
        $contact = new Contact;
=======
        $contact = new Contact();
>>>>>>> ac0ea089 (.)
        $contact->mail_count = 3;
        $contact->mail_sent_at = '2023-01-01 10:00:00';

        expect($contact->mail_count)->toBe(3);
        expect($contact->mail_sent_at)->toBe('2023-01-01 10:00:00');
    });

    test('contact can store personal information', function () {
<<<<<<< HEAD
        $contact = new Contact;
=======
        $contact = new Contact();
>>>>>>> ac0ea089 (.)
        $contact->first_name = 'Mario';
        $contact->last_name = 'Rossi';

        expect($contact->first_name)->toBe('Mario');
        expect($contact->last_name)->toBe('Rossi');
    });

    test('contact has verification tracking', function () {
<<<<<<< HEAD
        $contact = new Contact;
=======
        $contact = new Contact();
>>>>>>> ac0ea089 (.)
        $contact->token = 'abc123';
        $contact->verified_at = '2023-01-01 12:00:00';

        expect($contact->token)->toBe('abc123');
        expect($contact->verified_at)->toBe('2023-01-01 12:00:00');
    });

    test('contact has flexible attribute storage', function () {
<<<<<<< HEAD
        $contact = new Contact;
=======
        $contact = new Contact();
>>>>>>> ac0ea089 (.)
        $contact->attribute_1 = 'value1';
        $contact->attribute_2 = 'value2';

        expect($contact->attribute_1)->toBe('value1');
        expect($contact->attribute_2)->toBe('value2');
    });

    test('contact can track duplicate count', function () {
<<<<<<< HEAD
        $contact = new Contact;
=======
        $contact = new Contact();
>>>>>>> ac0ea089 (.)
        $contact->duplicate_count = 2;

        expect($contact->duplicate_count)->toBe(2);
    });

    test('contact has order column for sorting', function () {
<<<<<<< HEAD
        $contact = new Contact;
=======
        $contact = new Contact();
>>>>>>> ac0ea089 (.)
        $contact->order_column = 1;

        expect($contact->order_column)->toBe(1);
    });
});
