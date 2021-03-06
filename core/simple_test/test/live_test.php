<?php
    // $Id: live_test.php,v 1.2 2007/09/04 20:25:51 adamfranco Exp $
    
    if (!defined("SIMPLE_TEST")) {
        define("SIMPLE_TEST", "../");
    }
    require_once(SIMPLE_TEST . 'simple_unit.php');
    require_once(SIMPLE_TEST . 'socket.php');
    require_once(SIMPLE_TEST . 'http.php');

    class LiveTestCase extends UnitTestCase {
        function LiveTestCase() {
            $this->UnitTestCase();
        }
        function testSocket() {
            $socket = new SimpleSocket("www.lastcraft.com", 80);
            $this->assertFalse($socket->isError(), "Error [" . $socket->getError(). "]");
            $this->assertTrue($socket->isOpen());
            $this->assertTrue($socket->write("GET www.lastcraft.com/test/network_confirm.php HTTP/1.0\r\n"));
            $socket->write("Host: localhost\r\n");
            $socket->write("Connection: close\r\n\r\n");
            $this->assertEqual($socket->read(8), "HTTP/1.1");
            $socket->close();
            $this->assertEqual($socket->read(8), "");
        }
        function testHttp() {
            $http = new SimpleHttpRequest("www.lastcraft.com/test/network_confirm.php?gkey=gvalue");
            $http->setCookie(new SimpleCookie("ckey", "cvalue"));
            $this->assertIsA($reponse = $http->fetch(), "SimpleHttpResponse");
            $this->assertEqual($reponse->getResponseCode(), 200);
            $this->assertEqual($reponse->getMimeType(), "text/html");
            $this->assertWantedPattern(
                    '/A target for the SimpleTest test suite/',
                    $reponse->getContent());
             $this->assertWantedPattern(
                    '/gkey=gvalue/',
                    $reponse->getContent());
             $this->assertWantedPattern(
                    '/ckey=cvalue/',
                    $reponse->getContent());
        }
    }
    
?>