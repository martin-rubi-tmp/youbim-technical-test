<?php
use PHPUnit\Framework\TestCase;

use Youbim\Collections\RedBeanCollection;
use Youbim\Collections\UsersCollection;
use Youbim\Models\User;
use Youbim\API\ListUsersEndPoint;

class ListUsersEndPointTest extends TestCase
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

    public function testListingAllTheUsers()
    {
        UsersCollection::add(
            new User( "Bart", "Simpson", "bart.simpson@thesimpsons.org", "555 123" )
        );
        UsersCollection::add(
            new User( "Lisa", "Simpson", "lisa.simpson@thesimpsons.org", "555 123" )
        );

        $action = new ListUsersEndPoint();

        $response = $action->evaluate();

        $this->assertEquals( $response, [
            "success" => true,
            "data" => [
                "users" => [
                    [
                        "name" => "Bart", 
                        "last_name" => "Simpson", 
                        "email" => "bart.simpson@thesimpsons.org", 
                        "phone_number" => "555 123"
                    ],
                    [
                        "name" => "Lisa", 
                        "last_name" => "Simpson", 
                        "email" => "lisa.simpson@thesimpsons.org", 
                        "phone_number" => "555 123"
                    ]
                ]
            ]
        ]);
    }
}