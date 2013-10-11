BeanstalkCommandPut Class Ref
=============================

.. php:class:: BeanstalkCommandPut

    :Extends: :php:class:`BeanstalkCommand`
    :Description: The "put" command is for any process that wants to insert a job into the queue
    :Author: Joshua Dechant <jdechant@shapeup.com>


.. topic:: Class Methods

    * :php:meth:`BeanstalkCommandPut::__construct` -- Constructor
    * :php:meth:`BeanstalkCommandPut::getCommand` -- Get the command to send to the beanstalkd server
    * :php:meth:`BeanstalkCommandPut::getData` -- Get the data to send to the beanstalkd server with the command
    * :php:meth:`BeanstalkCommandPut::parseResponse` -- Parse the response for success or failure.

.. php:method:: __construct( $message [ , $priority = 65536 , $delay = 0 , $ttr = 120 ] )

    :Description: Constructor
    :param mixed $message: Message to put in the beanstalkd queue
    :param integer $priority: Job priority.
    :param integer $delay: Number of seconds to wait before putting the job in the ready queue.
    :param integer $ttr: Time to run. The number of seconds to allow a worker to run this job.

.. php:method:: getCommand(  )

    :Description: Get the command to send to the beanstalkd server
    :returns: *string*

.. php:method:: getData(  )

    :Description: Get the data to send to the beanstalkd server with the command
    :returns: *string*

.. php:method:: parseResponse( $response [ , $data = null , $conn = null ] )

    :Description: Parse the response for success or failure.
    :param string $response: Response line, i.e, first line in response
    :param string $data: Data recieved with reponse, if any, else null
    :param BeanstalkConnection $conn: BeanstalkConnection use to send the command
    :returns: *integer* Id of the inserted job
    :throws: *BeanstalkException* When the server runs out of memory
    :throws: *BeanstalkException* When the job body is malformed
    :throws: *BeanstalkException* When the job body is larger than max-job-size in the server
    :throws: *BeanstalkException* When any other error occurs


