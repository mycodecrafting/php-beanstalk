Beanstalk\\Command\\Bury Class Ref
==================================

.. php:namespace:: Beanstalk\Command

.. php:class:: Bury

    :Extends: :php:class:`Beanstalk\\Command`
    :Description: Bury command
    :Author: Joshua Dechant <jdechant@shapeup.com>


    The bury command puts a job into the "buried" state. Buried jobs are put into a
    FIFO linked list and will not be touched by the server again until a client
    kicks them with the "kick" command.

.. topic:: Class Methods

    * :php:meth:`Bury::__construct` -- Constructor
    * :php:meth:`Bury::getCommand` -- Get the bury command to send to the beanstalkd server
    * :php:meth:`Bury::parseResponse` -- Parse the response for success or failure.

.. php:method:: __construct( $id , $priority )

    :Description: Constructor
    :param integer $id: The job id to bury
    :param integer $priority: A new priority to assign to the job

.. php:method:: getCommand(  )

    :Description: Get the bury command to send to the beanstalkd server
    :returns: *string*

.. php:method:: parseResponse( $response [ , $data = null , $conn = null ] )

    :Description: Parse the response for success or failure.
    :param string $response: Response line, i.e, first line in response
    :param string $data: Data recieved with reponse, if any, else null
    :param Beanstalk\Connection $conn: BeanstalkConnection use to send the command
    :returns: *boolean* True if command was successful
    :throws: *\Beanstalk\Exception* When the job cannot be found
    :throws: *\Beanstalk\Exception* When any other error occurs


