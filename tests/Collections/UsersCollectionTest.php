<?php
use PHPUnit\Framework\TestCase;

use Youbim\Collections\RedBeanCollection;
use Youbim\Collections\UsersCollection;
use Youbim\Models\User;

class UsersCollectionTest extends TestCase
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
        UsersCollection::add(
            new User( "Lisa", "Simpson", "lisa.simpson@thesimpsons.org", "555 123" )
        );

        $created_user = UsersCollection::last();

        $this->assertEquals( "Lisa", $created_user->get_name() );
        $this->assertEquals( "Simpson", $created_user->get_last_name() );
        $this->assertEquals( "lisa.simpson@thesimpsons.org", $created_user->get_email() );
        $this->assertEquals( "555 123", $created_user->get_phone_number() );
    }

    public function testGettingTheLastAUser()
    {
        UsersCollection::add(
            new User( "Bart", "Simpson", "bart.simpson@thesimpsons.org", "555 123" )
        );
        UsersCollection::add(
            new User( "Lisa", "Simpson", "lisa.simpson@thesimpsons.org", "555 123" )
        );

        $created_user = UsersCollection::last();

        $this->assertEquals( "Lisa", $created_user->get_name() );
        $this->assertEquals( "Simpson", $created_user->get_last_name() );
        $this->assertEquals( "lisa.simpson@thesimpsons.org", $created_user->get_email() );
        $this->assertEquals( "555 123", $created_user->get_phone_number() );
    }

    public function testGettingAllTheUsers()
    {
        UsersCollection::add(
            new User( "Bart", "Simpson", "bart.simpson@thesimpsons.org", "555 123" )
        );
        UsersCollection::add(
            new User( "Lisa", "Simpson", "lisa.simpson@thesimpsons.org", "555 123" )
        );

        $users = UsersCollection::all();

        $user = $users[0];
        $this->assertEquals( "Bart", $user->get_name() );
        $this->assertEquals( "Simpson", $user->get_last_name() );
        $this->assertEquals( "bart.simpson@thesimpsons.org", $user->get_email() );
        $this->assertEquals( "555 123", $user->get_phone_number() );

        $user = $users[1];
        $this->assertEquals( "Lisa", $user->get_name() );
        $this->assertEquals( "Simpson", $user->get_last_name() );
        $this->assertEquals( "lisa.simpson@thesimpsons.org", $user->get_email() );
        $this->assertEquals( "555 123", $user->get_phone_number() );
    }
}