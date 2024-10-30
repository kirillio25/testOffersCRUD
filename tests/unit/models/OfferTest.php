<?php

namespace tests\unit\models;

use app\models\Offer;
use Codeception\Specify;
use Codeception\Test\Unit;

class OfferTest extends Unit
{
    use Specify;

    protected function _before()
    {
        \Yii::$app->db->createCommand()->truncateTable(Offer::tableName())->execute();
    }

    public function testOfferValidation()
    {
        $this->specify('Title and email are required fields', function() {
            $offer = new Offer();
            $this->assertFalse($offer->validate());
            $this->assertArrayHasKey('title', $offer->errors);
            $this->assertArrayHasKey('email', $offer->errors);
        });

        $this->specify('Email must have a valid format', function() {
            $offer = new Offer([
                'title' => 'Test Offer',
                'email' => 'invalid-email-format'
            ]);
            $this->assertFalse($offer->validate());
            $this->assertArrayHasKey('email', $offer->errors);
        });

        $this->specify('Email must be unique', function() {
            $offer1 = new Offer([
                'title' => 'First Offer',
                'email' => 'unique@example.com',
            ]);
            $offer1->save();

            $offer2 = new Offer([
                'title' => 'Duplicate Email Offer',
                'email' => 'unique@example.com',
            ]);
            $this->assertFalse($offer2->validate());
            $this->assertArrayHasKey('email', $offer2->errors);
        });

        $this->specify('Phone must not exceed 15 characters', function() {
            $offer = new Offer([
                'title' => 'Long Phone Test',
                'email' => 'testlongphone@example.com',
                'phone' => str_repeat('1', 16), // 16 characters
            ]);
            $this->assertFalse($offer->validate());
            $this->assertArrayHasKey('phone', $offer->errors);
        });
    }

    public function testOfferSave()
    {
        $this->specify('Offer is saved successfully when all fields are valid', function() {
            $offer = new Offer([
                'title' => 'Valid Offer',
                'email' => 'valid@example.com',
                'phone' => '1234567890',
            ]);
            $this->assertTrue($offer->save());
        });
    }
}
