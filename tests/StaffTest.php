<?php

use PHPUnit\Framework\TestCase;
use Model\Staff;
use Src\Auth\Auth;

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
    public function testAddLibrarian(string $login, string $password, string $firstName, string $lastName, bool $expected)
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

    /**
     * @dataProvider loginProvider
     * @runInSeparateProcess
     */
    public function testLogin(string $login, string $password, bool $expected)
    {
        $uniqueLogin = 'test_user_' . time();
        $data = [
            'login'       => $uniqueLogin,
            'password'    => '123456',
            'first_name'  => 'Тест',
            'last_name'   => 'Тестов',
            'address'     => 'Test Address',
            'phone_number'=> '89001234567'
        ];
        
        $staff = Staff::create($data);
        $this->assertNotNull($staff);
        
        $result = Auth::attempt([
            'login' => $login === 'valid' ? $uniqueLogin : $login,
            'password' => $password
        ]);
        
        $this->assertEquals($expected, $result);

        Staff::where('login', $uniqueLogin)->delete();
    }

    public static function additionProvider(): array
    {
        $uniqueLogin = 'test_user_' . time();
        
        return [
            [$uniqueLogin, '123456', 'Иван', 'Иванов', true],
            ['',           '123456', 'Иван', 'Иванов', false],
            [$uniqueLogin, '',       'Иван', 'Иванов', false],
            [$uniqueLogin, '123456', '',     'Иванов', false],
            [$uniqueLogin, '123456', 'Иван', '',       false],
        ];
    }

    public static function loginProvider(): array
    {
        return [
            ['valid',   '123456', true],
            ['valid',   'wrong',   false],
            ['invalid', '123456', false],
            ['',        '123456', false],
            ['valid',   '',       false],
        ];
    }
}