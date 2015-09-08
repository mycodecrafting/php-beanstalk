Beanstalk\\Exception Class Ref
==============================

.. php:namespace:: Beanstalk

.. php:class:: Exception

    :Extends: :php:class:`Exception`
    :Description: Beanstalk Exceptions
    :Author: Joshua Dechant <jdechant@shapeup.com>


.. topic:: Class Constants

  .. php:const:: OUT_OF_MEMORY
  .. php:const:: INTERNAL_ERROR
  .. php:const:: BAD_FORMAT
  .. php:const:: UNKNOWN_COMMAND
  .. php:const:: BURIED
  .. php:const:: NOT_FOUND
  .. php:const:: EXPECTED_CRLF
  .. php:const:: JOB_TOO_BIG
  .. php:const:: DEADLINE_SOON
  .. php:const:: TIMED_OUT
  .. php:const:: TUBE_NAME_TOO_LONG
  .. php:const:: NOT_IGNORED
  .. php:const:: UNKNOWN
  .. php:const:: SERVER_OFFLINE
  .. php:const:: SERVER_READ
  .. php:const:: SERVER_WRITE

.. topic:: Class Methods

    * :php:meth:`Exception::__construct`
    * :php:meth:`Exception::getCodeAsString` -- Get a string representation of a given code

.. php:method:: __construct( $message [ , $code = 0 , $previous = null ] )

    :param mixed $message:
    :param mixed $code:
    :param Beanstalk\Exception $previous:

.. php:method:: getCodeAsString(  )

    :Description: Get a string representation of a given code
    :returns: *string*


