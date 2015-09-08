Beanstalk\\Command Class Ref
============================

.. php:namespace:: Beanstalk

.. php:class:: Command

    :Description: Abstract beanstalk command.
    :Author: Joshua Dechant <jdechant@shapeup.com>


    All commands must extends this class

.. topic:: Class Methods

    * :php:meth:`Command::getCommand` -- Get the command to send to the beanstalkd server
    * :php:meth:`Command::getData` -- Get data, if any, to send with the command.
    * :php:meth:`Command::parseResponse` -- Parse the response for success or failure.
    * :php:meth:`Command::returnsData` -- Does the command return data?

.. php:method:: getCommand(  )

    :Description: Get the command to send to the beanstalkd server
    :returns: *string*

.. php:method:: getData(  )

    :Description: Get data, if any, to send with the command.
    :returns: *mixed* Data string to send with command or boolean false if none

    Not all commands have data; in fact, most do not.

.. php:method:: parseResponse( $response [ , $data = null , $conn = null ] )

    :Description: Parse the response for success or failure.
    :param string $response: Response line, i.e, first line in response
    :param string $data: Data recieved with reponse, if any, else null
    :param Beanstalk\Connection $conn: BeanstalkConnection use to send the command
    :returns: *mixed* On success
    :throws: *BeanstalkException* On failure

    Failures should throw a BeanstalkException with the error message.

.. php:method:: returnsData(  )

    :Description: Does the command return data?
    :returns: *boolean*


