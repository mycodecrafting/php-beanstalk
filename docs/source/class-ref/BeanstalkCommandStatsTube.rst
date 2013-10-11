BeanstalkCommandStatsTube Class Ref
===================================

.. php:class:: BeanstalkCommandStatsTube

    :Extends: :php:class:`BeanstalkCommand`
    :Description: The stats-tube command gives statistical information about the specified tube if it exists


.. topic:: Class Methods

    * :php:meth:`BeanstalkCommandStatsTube::__construct` -- Constructor
    * :php:meth:`BeanstalkCommandStatsTube::getCommand` -- Get the command to send to the beanstalkd server
    * :php:meth:`BeanstalkCommandStatsTube::parseResponse` -- Parse the response for success or failure.
    * :php:meth:`BeanstalkCommandStatsTube::returnsData` -- Does the command return data?

.. php:method:: __construct( $tube )

    :Description: Constructor
    :param string $tube: Stats will be returned for this tube.
    :throws: *BeanstalkException* When $tube exceeds 200 bytes

.. php:method:: getCommand(  )

    :Description: Get the command to send to the beanstalkd server
    :returns: *string*

.. php:method:: parseResponse( $response [ , $data = null , $conn = null ] )

    :Description: Parse the response for success or failure.
    :param string $response: Response line, i.e, first line in response
    :param string $data: Data recieved with reponse, if any, else null
    :param BeanstalkConnection $conn: BeanstalkConnection use to send the command
    :returns: *BeanstalkStats*
    :throws: *BeanstalkException* When the job does not exist
    :throws: *BeanstalkException* When any other error occurs

.. php:method:: returnsData(  )

    :Description: Does the command return data?
    :returns: *boolean*


