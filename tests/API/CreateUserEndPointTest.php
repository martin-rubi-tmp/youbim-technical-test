<?php
use PHPUnit\Framework\TestCase;

use Youbim\Collections\RedBeanCollection;
use Youbim\Collections\UsersCollection;
use Youbim\Models\User;
use Youbim\API\CreateUserEndPoint;

class CreateUserEndPointTest extends TestCase
{
    static public function setUpBeforeClass()
    {
        if( ! RedBeanCollection::is_connected() ) {
            RedBeanCollection::setup_connection( 'mysql:host=127.0.0.1;dbname=youbim_test', 'developer', '123456' );
        }
    }

    public function setUp()
    {
        UsersCollection::truncate();
    }

    public function testAddingAUser()
    {
        $action = new CreateUserEndPoint();

        $response = $action->evaluate([
                "user" => [
                    "name" => "Lisa", 
                    "last_name" => "Simpson", 
                    "email" => "lisa.simpson@thesimpsons.org", 
                    "phone_number" => "555 123"
                ]
            ]
        );

        $this->assertEquals( $response, [
            "success" => true,
            "data" => []
        ]);


        $created_user = UsersCollection::last();

        $this->assertEquals( "Lisa", $created_user->get_name() );
        $this->assertEquals( "Simpson", $created_user->get_last_name() );
        $this->assertEquals( "lisa.simpson@thesimpsons.org", $created_user->get_email() );
        $this->assertEquals( "555 123", $created_user->get_phone_number() );
    }

    public function testInvalidName()
    {
        $invalid_name_values =
        [
            null => [
                "success" => false,
                "errors" => [
                    "user.name" => [
                        "required" => "The User.name is required"
                    ]
                ]
            ],
            "" => [
                "success" => false,
                "errors" => [
                    "user.name" => [
                        "required" => "The User.name is required"
                    ]
                ]
            ],
            "Lisa!" => [
                "success" => false,
                "errors" => [
                    "user.name" => [
                        'alpha_dash' => 'The User.name only allows a-z, 0-9, _ and -'
                    ]
                ]
            ],
            str_repeat( "a", 32 + 1 ) => [
                "success" => false,
                "errors" => [
                    "user.name" => [
                        'max' => 'The User.name maximum is 32'
                    ]
                ]
            ]
        ];

        foreach( $invalid_name_values as $value => $expected_response ) {
            $action = new CreateUserEndPoint();

            $response = $action->evaluate([
                    "user" => [
                        "name" => $value,
                        "last_name" => "Simpson", 
                        "email" => "lisa.simpson@thesimpsons.org", 
                        "phone_number" => "555 123"
                    ]
                ]
            );

            $this->assertEquals( $expected_response, $response);

            $users = UsersCollection::all();

            $this->assertEquals( [], $users );
        }
    }

    public function testInvalidLastName()
    {
        $invalid_last_name_values =
        [
            null => [
                "success" => false,
                "errors" => [
                    "user.last_name" => [
                        "required" => "The User.last name is required"
                    ]
                ]
            ],
            "" => [
                "success" => false,
                "errors" => [
                    "user.last_name" => [
                        "required" => "The User.last name is required"
                    ]
                ]
            ],
            "Lisa!" => [
                "success" => false,
                "errors" => [
                    "user.last_name" => [
                        'alpha_dash' => 'The User.last name only allows a-z, 0-9, _ and -'
                    ]
                ]
            ],
            str_repeat( "a", 32 + 1 ) => [
                "success" => false,
                "errors" => [
                    "user.last_name" => [
                        'max' => 'The User.last name maximum is 32'
                    ]
                ]
            ]
        ];

        foreach( $invalid_last_name_values as $value => $expected_response ) {
            $action = new CreateUserEndPoint();

            $response = $action->evaluate([
                    "user" => [
                        "name" => "Lisa",
                        "last_name" => $value, 
                        "email" => "lisa.simpson@thesimpsons.org", 
                        "phone_number" => "555 123"
                    ]
                ]
            );

            $this->assertEquals( $expected_response, $response);

            $users = UsersCollection::all();

            $this->assertEquals( [], $users );
        }
    }

    public function testInvalidEmail()
    {
        $invalid_email_values =
        [
            null => [
                "success" => false,
                "errors" => [
                    "user.email" => [
                        "required" => "The User.email is required"
                    ]
                ]
            ],
            "" => [
                "success" => false,
                "errors" => [
                    "user.email" => [
                        "required" => "The User.email is required"
                    ]
                ]
            ],
            "lisa.simpson@thesimpsons" => [
                "success" => false,
                "errors" => [
                    "user.email" => [
                        'email' => 'The User.email is not valid email'
                    ]
                ]
            ],
            str_repeat( "a", 128 + 1 ) . "@thesimpsons.org" => [
                "success" => false,
                "errors" => [
                    "user.email" => [
                        'max' => 'The User.email maximum is 128',
                        'email' => 'The User.email is not valid email'
                    ]
                ]
            ]
        ];

        foreach( $invalid_email_values as $value => $expected_response ) {
            $action = new CreateUserEndPoint();

            $response = $action->evaluate([
                    "user" => [
                        "name" => "Lisa",
                        "last_name" => "Simpson", 
                        "email" => $value, 
                        "phone_number" => "555 123"
                    ]
                ]
            );

            $this->assertEquals( $expected_response, $response);

            $users = UsersCollection::all();

            $this->assertEquals( [], $users );
        }
    }

    public function testInvalidPhoneNumber()
    {
        $invalid_phone_number_values =
        [
            null => [
                "success" => false,
                "errors" => [
                    "user.phone_number" => [
                        "required" => "The User.phone number is required"
                    ]
                ]
            ],
            "" => [
                "success" => false,
                "errors" => [
                    "user.phone_number" => [
                        "required" => "The User.phone number is required"
                    ]
                ]
            ],
            str_repeat( "a", 32 + 1 ) => [
                "success" => false,
                "errors" => [
                    "user.phone_number" => [
                        'max' => 'The User.phone number maximum is 32',
                    ]
                ]
            ]
        ];

        foreach( $invalid_phone_number_values as $value => $expected_response ) {
            $action = new CreateUserEndPoint();

            $response = $action->evaluate([
                    "user" => [
                        "name" => "Lisa",
                        "last_name" => "Simpson", 
                        "email" => "lisa.simpson@thesimpsons.org", 
                        "phone_number" => $value
                    ]
                ]
            );

            $this->assertEquals( $expected_response, $response);

            $users = UsersCollection::all();

            $this->assertEquals( [], $users );
        }
    }
}