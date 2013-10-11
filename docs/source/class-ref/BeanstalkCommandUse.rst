BeanstalkCommandUse Class Ref
=============================

.. php:class:: BeanstalkCommandUse

    :Extends: :php:class:`BeanstalkCommand`
    :Description: Use command
    :Author: Joshua Dechant <jdechant@shapeup.com>


    The "use" command is for producers. Subsequent put commands will put jobs into
    the tube specified by this command. If no use command has been issued, jobs
    will be put into the tube named "default".

.. topic:: Class Methods

    * :php:meth:`BeanstalkCommandUse::__construct` -- Constructor
    * :php:meth:`BeanstalkCommandUse::getCommand` -- Get the command to send to the beanstalkd server
    * :php:meth:`BeanstalkCommandUse::parseResponse` -- Parse the response for success or failure.

.. php:method:: __construct( $tube )

    :Description: Constructor
    :param string $tube: The tube to use. If the tube does not exist, it will be created.
    :throws: *BeanstalkException* When $tube exceeds 200 bytes

.. php:method:: getCommand(  )

    :Description: Get the command to send to the beanstalkd server
    :returns: *string*

.. php:method:: parseResponse( $response [ , $data = null , $conn = null ] )

    :Description: Parse the response for success or failure.
    :param string $response: Response line, i.e, first line in response
    :param string $data: Data recieved with reponse, if any, else null
    :param BeanstalkConnection $conn: BeanstalkConnection use to send the command
    :returns: *string* The name of the tube now being used
    :throws: *BeanstalkException* When any error occurs


