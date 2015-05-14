Beanstalk\\Command\\ListTubes Class Ref
=======================================

.. php:namespace:: Beanstalk\Command

.. php:class:: ListTubes

    :Extends: :php:class:`Beanstalk\\Command`
    :Description: The list-tubes command returns a list of all existing tubes
    :Author: Joshua Dechant <jdechant@shapeup.com>


.. topic:: Class Methods

    * :php:meth:`ListTubes::getCommand` -- Get the command to send to the beanstalkd server
    * :php:meth:`ListTubes::parseResponse` -- Parse the response for success or failure.
    * :php:meth:`ListTubes::returnsData` -- Does the command return data?

.. php:method:: getCommand(  )

    :Description: Get the command to send to the beanstalkd server
    :returns: *string*

.. php:method:: parseResponse( $response [ , $data = null , $conn = null ] )

    :Description: Parse the response for success or failure.
    :param string $response: Response line, i.e, first line in response
    :param string $data: Data recieved with reponse, if any, else null
    :param Beanstalk\Connection $conn: BeanstalkConnection use to send the command
    :returns: *array* List of all existing tubes
    :throws: *\Beanstalk\Exception* When any error occurs

.. php:method:: returnsData(  )

    :Description: Does the command return data?
    :returns: *boolean*


