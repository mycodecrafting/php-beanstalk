Beanstalk\\Command\\StatsTube Class Ref
=======================================

.. php:namespace:: Beanstalk\Command

.. php:class:: StatsTube

    :Extends: :php:class:`Beanstalk\\Command`
    :Description: The stats-tube command gives statistical information about the specified tube if it exists


.. topic:: Class Methods

    * :php:meth:`StatsTube::__construct` -- Constructor
    * :php:meth:`StatsTube::getCommand` -- Get the command to send to the beanstalkd server
    * :php:meth:`StatsTube::parseResponse` -- Parse the response for success or failure.
    * :php:meth:`StatsTube::returnsData` -- Does the command return data?

.. php:method:: __construct( $tube )

    :Description: Constructor
    :param string $tube: Stats will be returned for this tube.
    :throws: *\Beanstalk\Exception* When $tube exceeds 200 bytes

.. php:method:: getCommand(  )

    :Description: Get the command to send to the beanstalkd server
    :returns: *string*

.. php:method:: parseResponse( $response [ , $data = null , $conn = null ] )

    :Description: Parse the response for success or failure.
    :param string $response: Response line, i.e, first line in response
    :param string $data: Data recieved with reponse, if any, else null
    :param Beanstalk\Connection $conn: BeanstalkConnection use to send the command
    :returns: *\Beanstalk\Stats*
    :throws: *\Beanstalk\Exception* When the job does not exist
    :throws: *\Beanstalk\Exception* When any other error occurs

.. php:method:: returnsData(  )

    :Description: Does the command return data?
    :returns: *boolean*


