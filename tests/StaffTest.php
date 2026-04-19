<?php

use PHPUnit\Framework\TestCase;
use Model\Staff;

class StaffTest extends TestCase
{
    protected function setUp(): void
    {
        $_SERVER['DOCUMENT_ROOT'] = 'C:/xampp/htdocs';
        
        $GLOBALS['app'] = new Src\Application(new Src\Settings([
            'app'  => include $_SERVER['DOCUMENT_ROOT'] . '/server/config/app.php',
            'db'   => include $_SERVER['DOCUMENT_ROOT'] . '/server/config/db.php',
            'path' => include $_SERVER['DOCUMENT_ROOT'] . '/server/config/path.php',
        ]));
        
        if (!function_exists('app')) {
            function app() {
                return $GLOBALS['app'];
            }
        }
    }

    /**
     * @dataProvider additionProvider
     * @runInSeparateProcess
     */
    public function testAddLibrarian(string $login, string $password, string $firstName, string $lastName, bool $expected, string $expectedMessage)
    {
        $data = [
            'login'       => $login,
            'password'    => $password,
            'first_name'  => $firstName,
            'last_name'   => $lastName,
            'address'     => 'Test Address',
            'phone_number'=> '89001234567'
        ];
        
        try {
            $staff = Staff::create($data);
            
            if ($expected) {
                $this->assertNotNull($staff);
                Staff::where('login', $login)->delete();
            } else {
                $this->assertNull($staff);
            }
        } catch (\Exception $e) {
            $this->assertFalse($expected);
        }
    }

    public static function additionProvider(): array
    {
        $uniqueLogin = 'test_user_' . time();
        
        return [
            [$uniqueLogin, '123456', 'Иван', 'Иванов', true, ''],
            ['',           '123456', 'Иван', 'Иванов', false, 'Поле login пусто'],
            [$uniqueLogin, '',       'Иван', 'Иванов', false, 'Поле password пусто'],
            [$uniqueLogin, '123456', '',     'Иванов', false, 'Поле first_name пусто'],
            [$uniqueLogin, '123456', 'Иван', '',       false, 'Поле last_name пусто'],
        ];
    }
}