<?php
    // $Id: observer.php,v 1.2 2005/01/19 16:33:26 adamfranco Exp $
    
    if (!defined("SIMPLE_TEST")) {
        define("SIMPLE_TEST", "./");
    }
    
    /**
     *    Part of observer pattern. Interface for test issued
     *    events. Should also paint itself by accepting a
     *    visiting painter in subclasses.
     */
    class TestEvent {
        var $_label;
        
        /**
         *    Sets the event label.
         *    @param $label     Message to be carried by the event.
         *    @access public
         */
        function TestEvent($label) {
            $this->_label = $label;
        }
        
        /**
         *    Accessor for the event message.
         *    @return     Event message.
         *    @access public
         */
        function getLabel() {
            return $this->_label;
        }
        
        /**
         *    Accepts visiting painter.
         *    @param $painter    TestReporter class to write to.
         *    @abstract
         */
        function paint(&$painter) {
        }
    }
    
    /**
     *    Generated by a test on either a pass or fail.
     *    Can use a visiting painter to display the
     *    correct result.
     */
    class TestResult extends TestEvent {
        var $_result;
        
        /**
         *    Stashes the result, true for a pass, and the test
         *    label.
         *    @param $result    True if passed.
         *    @param $label     Message to be carried by the event.
         *    @access public
         */
        function TestResult($result, $label = "") {
            $this->TestEvent($label);
            $this->_result = $result;
        }
        
        /**
         *    Paints the approppriate result to the visting
         *    TestReporter.
         *    @param $painter    TestReporter class to write to.
         *    @access public
         */
        function paint(&$painter) {
            if ($this->_result) {
                $painter->paintPass($this->getLabel());
            } else {
                $painter->paintFail($this->getLabel());
            }
        }
    }

    /**
     *    Issued at the start of a test. This allows the
     *    test painter to keep internal records of which
     *    tests are currently running, etc.
     *    The test name and type are sent.
     */
    class TestStart extends TestEvent {
        var $_size;

        /**
         *    Stashes the starting message, usually a test name.
         *    @param $label     Message to be carried by the event.
         *    @param $size      The number of test cases in this test.
         *    @access public
         */
        function TestStart($label, $size = 0) {
            $this->TestEvent($label);
            $this->_size = $size;
        }
        
        /**
         *    Paints itself into the visiting painter.
         *    @param $painter    TestReporter class to write to.
         *    @access public
         */
        function paint(&$painter) {
            $painter->paintStart($this->getLabel(), $this->_size);
        }
    }

    /**
     *    Issued at the end of a test. This allows the
     *    test painter to keep internal records of which
     *    tests are currently running, etc.
     */
    class TestEnd extends TestEvent {
        var $_size;
        
        /**
         *    Stashes the ending message, usually a test name.
         *    @param $label     Message to be carried by the event.
         *    @param $size      The number of test cases in this test.
         *    @access public
         */
        function TestEnd($label, $size = 0) {
            $this->TestEvent($label);
            $this->_size = $size;
        }
        
        /**
         *    Paints itself into the visiting painter.
         *    @param $painter    TestReporter class to write to.
         *    @param $type       Type of object sending the event.
         *    @access public
         */
        function paint(&$painter) {
            $painter->paintEnd($this->getLabel(), $this->_size);
        }
    }

    /**
     *    Base class that can attach and notify observing
     *    objects.
     */
    class TestObservable {
        var $_observers;
        
        /**
         *    Starts with an empty list of observers.
         *    @access public
         */
        function TestObservable() {
            $this->_observers = array();
        }
        
        /**
         *    Adds an object with a notify() method.
         *    @param $observer    Observer added to the internal list.
         *    @access public
         */
        function attachObserver(&$observer) {
            $this->_observers[] = &$observer;
        }
        
        /**
         *    Passes the event object down to the notify()
         *    method of all of it's observers.
         *    @param $event        Event to pass on.
         *    @access public
         */
        function notify(&$event) {
            for ($i = 0; $i < count($this->_observers); $i++) {
                $this->_observers[$i]->notify(&$event);
            }
        }
    }
    
    /**
     *    Interface definition for object that can be attached
     *    to the observer. Not used (for mocking only).
     */
    class TestObserver {
        
        /**
         *    Do nothing constructor.
         *    @abstract
         */
        function TestObserver() {
        }
        
        /**
         *    Does nothing with the incoming event. Abstract.
         *    @param $event    Event to acted upon.
         *    @access public
         */
        function notify(&$event) {
        }
    }
    
    /**
     *    Can recieve test events and display them. Display
     *    is achieved by making display methods available
     *    and visiting the incoming event. Abstract.
     */
    class TestReporter extends TestObserver {
        
        /**
         *    Does nothing.
         *    @access public
         */
        function TestReporter() {
            $this->TestObserver();
        }
        
        /**
         *    Handles the incoming event by invoking it's paint()
         *    method passing itself in as a visitor.
         *    This makes extending this class easier as the
         *    interface is more natural from the display
         *    point of view.
         *    @param $event        Event to show.
         *    @access public
         */
        function notify(&$event) {
            $event->paint(&$this);
        }
        
        /**
         *    Paints the start of a test.
         *    @param $test_name        Name of test or other label.
         *    @param $size             Number of test cases starting.
         *    @access public
         */
        function paintStart($test_name, $size) {
        }
        
        /**
         *    Paints the end of a test.
         *    @param $test_name        Name of test or other label.
         *    @param $size             Number of cases just finished.
         *    @access public
         */
        function paintEnd($test_name, $size) {
        }
        
        /**
         *    Paints a pass. This will often output nothing.
         *    @param $message        Passing message.
         *    @access public
         */
        function paintPass($message) {
        }
        
        /**
         *    Paints a failure.
         *    @param $message        Failure message from test.
         *    @access public
         */
        function paintFail($message) {
        }
    }
?>