
Harmoni v. 1.5.0 (2008-08-13)
=================================

What is Harmoni?
------------------
The Harmoni Project is an effort led by the Curricular Technologies group at
Middlebury College to build an application framework and standards-based
infrastructure bus to support the rapid development and easy maintenance of
curricular it projects. The project is built entirely using PHP's OOP (Object
Oriented Programming) model, allowing the framework code to be easily extended and enhanced.

At the core of the Harmoni Application Framework is an implementation of The Open
Knowledge Initiative's (O.K.I) Open Service Interface Definitions (OSIDs). The OSIDs
are a standard service-oriented API that defines a broad set of services that are
germane to IT projects in the education field yet also fitting for broader uses.

Sitting alongside of the Harmoni services is the "Harmoni Architecture". The
"architecture" is a set of controllers and templates that coordinate configuration
of services, the proper execution of application actions, and any post-processing of
application output. The architecture is built on a popular module/action model, in
which your PHP program contains multiple modules, each of which contain multiple
executable actions. All you, as an application developer, need to write are the
action files, not the controller logic.

The "Harmoni Architecture" is separate from the Harmoni Services and either can be
used independently of the other.


Current Version Notes
---------------------
This release makes several improvements to the Authorization, Repository, and
Request systems to support Segue 2. See the change log for details.


Downloads
---------------------
For the latest and archived versions, please download from SourceForge:

http://sourceforge.net/project/showfiles.php?group_id=82873


Documentation
---------------------
See the Harmoni wiki for online documentation:

http://harmoni.sf.net/


Bug Tracker
---------------------
https://sourceforge.net/tracker/?group_id=82873&atid=567473







===================================================================
| Prior Harmoni Release Notes
| (See the Harmoni change log for more details)
===================================================================


v. 1.5.0 (2008-08-13)
----------------------------------------------------
This release makes several improvements to the Authorization, Repository, and
Request systems to support Segue 2. See the change log for details.



v. 1.4.7 (2008-08-07)
----------------------------------------------------
This release fixes an authorization issue as well as enhances security by preventing
Javascript from being written to the logs. See the change log for details.



v. 1.4.6 (2008-08-01)
----------------------------------------------------
This release fixes a number of issues that were affecting Segue 2.

Most important is a fix to the image-processor to correctly support generation of
thumbnails from multi-page PDF files.



v. 1.4.5 (2008-07-24)
----------------------------------------------------
This release fixes a few minor issues that were causing problems with Segue.



v. 1.4.4 (2008-07-21)
----------------------------------------------------
This release fixes an issue with Authorization settings for members of groups the
ids of which contain quotes.



v. 1.4.3 (2008-07-17)
----------------------------------------------------
This release fixes several issues with Themes and Logging.



v. 1.4.2 (2008-07-11)
----------------------------------------------------
This release includes a minor improvement to support Segue.



v. 1.4.1 (2008-07-10)
----------------------------------------------------
This release adds some minor improvements to support Segue.



v. 1.4.0 (2008-06-16)
----------------------------------------------------
This release includes two improvements:

* The ActionHandler now supports the specification of default parameters to be used
when the default module and action are used. * New methods for converting strings to
UTF-8 and converting 'smart-quotes'. Usage of this new String->makeUtf8() method
requires PHP to be compiled with the --enable-mbstring option.



v. 1.3.5 (2008-06-13)
----------------------------------------------------
Harmoni versions 1.2.0 through 1.3.4 included a bug in AuthZ2 in which implicit
authorizations were not created when new nodes were created with
Hierarchy->createNode(). This release fixes that issue.

For other improvements please see the change-log.



v. 1.3.4 (2008-06-09)
----------------------------------------------------
This release adds support for a visitor registration authentication method.



v. 1.3.3 (2008-06-03)
----------------------------------------------------
This release fixes a few issues that were affecting Concerto, most notably, several
issues with safe-mode restrictions when creating or extracting tar archives. 

Harmoni now includes a custom version of the Archive/Tar PEAR library with a fix
for bug #14058 that prevents proper extraction of archives with Safe Mode on.



v. 1.3.2 (2008-05-23)
----------------------------------------------------
This release fixes a few errors affected a few users, notably a work-around for a
PHP/PDO bug that results in segmentation faults when escaped quotes exist in an
SQLstring that is then prepared. This is occurring when checking authorization for
users who are members of groups that have a quote in their LDAP DN.



v. 1.3.1 (2008-05-22)
----------------------------------------------------
This release fixes a minor theming issue that was affecting the Polyphony
log-browsing actions.



v. 1.3.0 (2008-05-20)
----------------------------------------------------
This release adds support for a new Theming system, Gui2. Gui2 simplifies the
expectations of themes to allow a wider range of possible implementations and
storage techniques.

As well, a number of minor bugs have been fixed.



v. 1.2.0 (2008-05-05)
----------------------------------------------------
This release includes a new implementation of the Authorization and Hierarchy
services along side of the original implementations. This new 'AuthZ2'
implementation stores hierarchy and authorization data in a set of tables with
foreign-key constraints/triggers to manage the removal of authorizations when nodes
in the hierarchy are dropped. As well, AuthZ2 stores implicit authorizations as rows
in an implicit_azs table to allow simple lookups without the need of traversing the
hierarchy at read-time. AuthZ2 enables Segue to run approximately 600% faster, with
some operations seeing 2000% decreases in execution time.

Additional improvements in this release include more robust Harmoni_Db support, as
well as fixes to Tagging, Language, and Database services.



v. 1.1.0 (2008-04-11)
----------------------------------------------------
This release adds a new database access and SQL query system, Harmoni_Db. Harmoni_Db
is an extension of Zend_Db and adds Harmoni query-building syntax to the Zend_Db
system. Through Harmoni_Db, prepared SQL statements are now supported and can be
configured for use in the Hierarchy and AgentManagement services for increased performance.

See the change log for additional fixes and improvements.



v. 1.0.6 (2008-04-02)
----------------------------------------------------
In addition to a few bug fixes elsewhere, this release improves the
LanguageLocalizer to support all ISO 639-3 language codes and adds native
translation of language names from Wikipedia.org.



v. 1.0.5 (2008-03-25)
----------------------------------------------------
This release includes some improvements to enable more flexibility in the Request
system as well as fixes a few minor issues.



v. 1.0.4 (2008-03-12)
----------------------------------------------------
This release updates the default case of column names in several minor database
tables. 



v. 1.0.3 (2008-03-10)
----------------------------------------------------
This release fixes a few bugs.



v. 1.0.2 (2008-03-03)
----------------------------------------------------
This release fixes a few minor bugs.



v. 1.0.1 (2008-02-21)
----------------------------------------------------
This release fixes an issue in which Cookie values were being appended to some URLs.
Also fixes a few other typos and bugs.



v. 1.0.0 (2008-02-15)
----------------------------------------------------
This release includes a newly generated set of the O.K.I. OSIDs as PHP5 interfaces
instead of concrete classes. As well, a number of bug have been fixed and the
reliability of PATH_INFO-based urls has been improved.



v. 0.13.8 (2008-01-15)
----------------------------------------------------
A minor fix to Group searching.



v. 0.13.7 (2008-01-14)
----------------------------------------------------
This release fixes a few minor issues.



v. 0.13.6 (2007-12-20)
----------------------------------------------------
This release fixes a few minor bugs.



v. 0.13.5 (2007-12-12)
----------------------------------------------------
This release adds a few minor fixes and a few minor cleanup changes. It also
includes the addition of HTML cleaning support, available through the HtmlString
'primitive' class. This support can be used by client applications to strip HTML
markup of tags and attributes that might result in XSS attacks.



v. 0.13.4 (2007-11-13)
----------------------------------------------------
This release fixes a few minor issues with the Error Handler.



v. 0.13.3 (2007-11-09)
----------------------------------------------------
This release fixes a few minor bugs and adds the ability to attach
externally-defined groups (such as from LDAP) underneath locally defined groups.

Changes to the Agent tables require running a database updater script:
harmoni/core/DBHandler/db_updater.php 



v. 0.13.2 (2007-11-01)
----------------------------------------------------
This release fixes a few minor bugs and improves support for using the Harmoni
Architecture via a command line interface.



v. 0.13.1 (2007-10-22)
----------------------------------------------------
This release fixes a few issues that were missed in the last point release.



v. 0.13.0 (2007-10-22)
----------------------------------------------------
New in this release include the addition of alternate repository implementations for
reading from simple database tables and federating together several different
repository implementations.

Also, Be sure to point the database updater script
(harmoni/core/DBHandler/db_updater.php) at your harmoni databases to add new columns
that changed in harmoni-0.11.0 and harmoni-0.12.0.

Changes to the Logging tables require running a database updater script:
harmoni/core/DBHandler/db_updater.php 



v. 0.12.3 (2007-09-25)
----------------------------------------------------




v. 0.12.2 (2007-09-20)
----------------------------------------------------




v. 0.12.1 (2007-09-14)
----------------------------------------------------




v. 0.12.0 (2007-09-13)
----------------------------------------------------




v. 0.11.0 (2007-09-07)
----------------------------------------------------




v. 0.10.1 (2007-04-10)
----------------------------------------------------




v. 0.10.0 (2007-04-05)
----------------------------------------------------




v. 0.9.0 (2006-12-13)
----------------------------------------------------




v. 0.8.0 (2006-12-01)
----------------------------------------------------




v. 0.7.10 (2006-11-30)
----------------------------------------------------




v. 0.7.9 (2006-11-28)
----------------------------------------------------




v. 0.7.8 (2006-10-25)
----------------------------------------------------




v. 0.7.7 (2006-08-28)
----------------------------------------------------




v. 0.7.6 (2006-08-15)
----------------------------------------------------




v. 0.7.5 (2006-08-11)
----------------------------------------------------




v. 0.7.4 (2006-08-04)
----------------------------------------------------




v. 0.7.3 (2006-08-02)
----------------------------------------------------




v. 0.7.2 (2006-07-21)
----------------------------------------------------




v. 0.7.1 (2006-06-20)
----------------------------------------------------




v. 0.7.0 (2006-06-16)
----------------------------------------------------




v. 0.6.1 (2006-05-19)
----------------------------------------------------




v. 0.6.0 (2006-05-05)
----------------------------------------------------




v. 0.5.1 (2005-02-09)
----------------------------------------------------




v. 0.5.0 (2005-01-10)
----------------------------------------------------




v. 0.4.0 (2005-10-12)
----------------------------------------------------




v. 0.3.3 (Never Released)
----------------------------------------------------




v. 0.3.2 (2005-04-14)
----------------------------------------------------




v. 0.3.1 (2005-04-11)
----------------------------------------------------




v. 0.3.0 (2005-04-07)
----------------------------------------------------




v. 0.2.0 (2004-10-26)
----------------------------------------------------




v. 0.1.0 (2004-06-11)
----------------------------------------------------




v. 0.0.5 (2004-01-09)
----------------------------------------------------




v. 0.0.4 (2003-12-06)
----------------------------------------------------




v. 0.0.3 (2003-11-26)
----------------------------------------------------




v. 0.0.2 (2003-09-28)
----------------------------------------------------




v. 0.0.1 (2003-07-10)
----------------------------------------------------




