BeanstalkCommandStats Class Ref
===============================

.. php:class:: BeanstalkCommandStats

    :Extends: :php:class:`BeanstalkCommand`
    :Description: The stats command gives statistical information about the system as a whole
    :Author: Joshua Dechant <jdechant@shapeup.com>


.. topic:: Class Methods

    * :php:meth:`BeanstalkCommandStats::getCommand` -- Get the command to send to the beanstalkd server
    * :php:meth:`BeanstalkCommandStats::parseResponse` -- Parse the response for success or failure.
    * :php:meth:`BeanstalkCommandStats::returnsData` -- Does the command return data?

.. php:method:: getCommand(  )

    :Description: Get the command to send to the beanstalkd server
    :returns: *string*

.. php:method:: parseResponse( $response [ , $data = null , $conn = null ] )

    :Description: Parse the response for success or failure.
    :param string $response: Response line, i.e, first line in response
    :param string $data: Data recieved with reponse, if any, else null
    :param BeanstalkConnection $conn: BeanstalkConnection use to send the command
    :returns: *BeanstalkStats*
    :throws: *BeanstalkException* When any error occurs

.. php:method:: returnsData(  )

    :Description: Does the command return data?
    :returns: *boolean*


