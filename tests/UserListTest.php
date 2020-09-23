<?php

class UserListTest extends TestCase {

    public function testShouldList_WhenMethodIsGet()
    {
        $response = $this->call('GET', '/user');

        $this->assertEquals(200, $response->status());
    }

    public function testShouldNotList_WhenMethodIsPut()
    {
        $response = $this->call('PUT', '/user');

        $this->assertEquals(405, $response->status());
    }

    public function testShouldNotList_WhenMethodIsPatch()
    {
        $response = $this->call('PATCH', '/user');

        $this->assertEquals(405, $response->status());
    }

    public function testShouldNotList_WhenMethodIsDelete()
    {
        $response = $this->call('DELETE', '/user');

        $this->assertEquals(405, $response->status());
    }


}
