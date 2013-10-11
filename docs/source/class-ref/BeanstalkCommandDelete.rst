BeanstalkCommandDelete Class Ref
================================

.. php:class:: BeanstalkCommandDelete

    :Extends: :php:class:`BeanstalkCommand`
    :Description: Delete command
    :Author: Joshua Dechant <jdechant@shapeup.com>


    The delete command removes a job from the server entirely. It is normally used
    by the client when the job has successfully run to completion. A client can
    delete jobs that it has reserved, ready jobs, and jobs that are buried.

.. topic:: Class Methods

    * :php:meth:`BeanstalkCommandDelete::__construct` -- Constructor
    * :php:meth:`BeanstalkCommandDelete::getCommand` -- Get the delete command to send to the beanstalkd server
    * :php:meth:`BeanstalkCommandDelete::parseResponse` -- Parse the response for success or failure.

.. php:method:: __construct( $id )

    :Description: Constructor
    :param integer $id: The job id to delete

.. php:method:: getCommand(  )

    :Description: Get the delete command to send to the beanstalkd server
    :returns: *string*

.. php:method:: parseResponse( $response [ , $data = null , $conn = null ] )

    :Description: Parse the response for success or failure.
    :param string $response: Response line, i.e, first line in response
    :param string $data: Data recieved with reponse, if any, else null
    :param BeanstalkConnection $conn: BeanstalkConnection use to send the command
    :returns: *boolean* True if command was successful
    :throws: *BeanstalkException* When the job cannot be found or has already timed out
    :throws: *BeanstalkException* When any other error occurs


