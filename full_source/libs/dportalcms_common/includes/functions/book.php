<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  eBook publisher, functions (book.php)       #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

if(!defined('DPORTAL')) die;

/* Note: This comments are too large.
 *
 * Technical information (in File-based version only):
 *
 * Database (csv files!!!) is divided in two type of files:
 *
 * - Books list (single file) 'books.lst'
 * - Chapter files (multiple files) 'unsueno.lst', 'dulcemelodia.lst', etc.
 *
 * Each file contains Metadata such Title and Timestamp of creation.
 *
 * Books list containt a list of Books published. Name should be a single word
 * without any special characters. Title may contain any special non-ASCII characters.
 * Chapters is the same of above.
 *
 * ------------------------------------------------------------------------------------------
 *
 * DBMS version: Currently I migrated all code to be compatible with DBA of phpBB.
 *
 * Here have 4 tables in the phpBB Database:
 *
 *	`book_books`,`book_chapters`,`book_comments` and `book_reads`
 *
 * `book_books` is the table with the Book list. It has the following fields:
 *
 *	`id` The ID of the Book. PRYMARY_KEY and AUTOINCREMENT.
 *
 *	`name` A name for identyfing, with the author prefix (author_name). UNIQUE and INDEX.
 *
 *	`title` The Title or a descriptive name of the Book.
 *
 *	`summary` A short summary of the Book.
 *
 *	`created` The creation date as TIMESTAMP.
 *
 *	`author` phpBB User ID.
 *
 *	`license` The License choice as INTEGER (many options are INTEGER in this field).
 *
 *	`category` The Category of the book.
 *
 *	`mature` Boolean if Story if not suitable for children.
 *
 * `book_chapters` with the Chapters published. It has the following fields:
 *
 *	`id` The ID. PRIMARY_KEY and AUTOINCREMENT.
 *
 *	`book` The Book asociated. FOREIGN KEY to `book_books`.`id`
 *
 *	`name` The Number of Chapter
 *
 *	`title` The title of the chapter
 *
 *	`created` The date of creation as TIMESTAMP
 *
 *	`updated` The date of last update as TIMESTAMP
 *
 *	`content` The contents of the Chapter as BLOB. Content is compressed and should be
 *	          stored in the DB as BINARY, and BLOB is de correct format.
 *
 *`book_comments` The Comments of the Chapters published by the people
 *
 *	`id` The ID. PRIMARY_KEY and AUTOINCREMENT.
 *
 *	`book` The Book associated. FOREIGN KEY to `book_books`.`id`
 *
 *	`chapter` The same for Chapter. FOREIGN KEY to `book_chapter`.`name`
 *
 *	`user` The user that published the comment. If an Anonymous user post a comment,
 *	       the field content is the Nickname as String. If a registered user post them,
 *	       the phpBB User ID will be stored. 
 *
 *	`url` The Website, if visitor provided them.
 *
 *	`ip` The IP address of the commenter.
 *
 *	`timestamp` The date of publishing as TIMESTAMP
 *
 *	`moderated` The state of message. See post_comment() for more information
 *
 *	`note` The calification from the reader (1, poor; 2, normal; 3, awesome)
 *
 *	`content` The content, compressed and stored as BLOB.
 *
 * `book_reads` The absolute reads of chapters.
 *
 *	`id` The ID ¬¬ PRIMARY_KEY and AUTOINCREMENT
 *
 *	`timestamp` Tha date and hour of read, as TIMESTAMP
 *
 *	`book` The Book associated. FOREIGN KEY to `book_books`.`id`
 *
 *	`chapter` The Chapter associated. FOREIGN KEY to `book_chapters`.`name`
 *
 *	Please end later, I' sleepy =__= (sí, lo dije en inglés, Tsory ¬¬)
 */ 

// :: END OF COMMENTS


/* Get the list of Books
 *
 * get_books() will return an Array with the Books stored in Server, filtered by Book and Author.
 *
 * Parameters:
 *
 *	* string book.
 *	   The name of the Book (see create_book for naming). This parameter is optional.
 *	
 *	* string author.
 *	   The author's name. This parameter is optional, too.
 *
 *	* int limit.
 *	   Limit the number of stories to obtain.
 *	   Also orders by Popularity instead of Alphabetical
 *
 * Returned values:
 *
 * This function will return an Array from the List, based on the filter by parameters.
 *
 * If List is empty, this function will return NULL.
 *
 * If error ocurred (file is unassessable) will return FALSE.
 *
*/

// array get_books([string book = null[, int author = null[, int limit = 0,[int mode = null]]]])	
function get_books($category = null, $author = null, $book = null, $limit = 0, $mode = null){

	global $db;
	
	if(!is_integer($limit)) $limit = 0;
	if(!empty($author)) $author = get_user($author,1);
	if(is_numeric($category)) settype($category,'int');

	if(!empty($book) && !empty($author)) $sql = "SELECT * FROM `book_books` WHERE `name` = '".mysql_real_escape_string($book)."' AND `author` = '".mysql_real_escape_string($author)."' ORDER  by `points` DESC LIMIT 1"; // Specific book (use $db->sql_fetcrow()!!!
	elseif(empty($book) && !empty($author)) $sql = "SELECT * FROM `book_books` WHERE `author` = '".mysql_real_escape_string($author)."' ORDER by `points` DESC"; // All books from Author
	elseif(empty($book) && empty($author) && is_integer($limit) && is_int($category)) $sql = "SELECT * FROM `book_books` WHERE `category` = $category ORDER by `points` DESC LIMIT $limit"; // All books, with limit (we checked the values as INTEGER), and is not necesary to use mysql_real_escape_string()
	elseif(empty($book) && empty($author) && is_integer($limit)) $sql = "SELECT * FROM `book_books` ORDER by `points` DESC LIMIT $limit"; // All books, with limit (we checked the values as INTEGER), and is not necesary to use mysql_real_escape_string()
	else $sql = "SELECT * FROM `book_books` ORDER by `points` DESC"; // If Book is null, get all books

	// Perform the Query against the database
	$result = $db->sql_query($sql);
	if(!empty($book)) $row = $db->sql_fetchrow($result);
	else $row = $db->sql_fetchrowset($result);

	if(empty($row)) return false;

	// Get the points for Author
	if(empty($book) && !empty($author)){
		foreach($row as $getrow){
			// Global Points for Author is the Points fromm each Book,
			// plus 10 points for each Book.
			$points = $getrow['points'] + $points + 10;
			$stories++;
		}
		return array($row,$stories,$points);
	}
	else return $row;
}


/* Get the list of Chapters from the given book
 *
 * get_chapters() will return the list of chapters of the given book, or metadata
 * of a single chapter if given, as Array. Also, an option for Check only is available.
 *
 * Parameters:
 *
 *	* string book
 *	   The Book name.
 *
 *	* int chapter
 *	   The chapter number.
 *
 *	* int author
 *	   The phpBB User ID that created the Book.
 *
 *	* bool content
 *	   If the content should be returned or not
 *
 *	* bool checkonly
 *	   If you want to only check if chapter exist
 *
 *
 * Returned values:
 *
 * This function will return an Array of the metadata of the given chapter.
 * If $checkonly is TRUE, this function will return only the Timestamp of the last update,
 * because the is impossible to get with the second call using Caching.
 * If list is empty or error ocurred, this function will return FALSE. 
 *
 *
*/

// mixed get_chapters(string book[, int chapter[, int author[, bool content[, bool onlycheck]]]])
function get_chapters($book,$chapter = null, $author = null,$content = false,$onlycheck = false){

	if(is_numeric($chapter) && !empty($chapter)) settype($chapter, 'int');
	elseif(!is_numeric($chapter) && !empty($chapter)) return false;

	global $db;
	
	$author = get_user($author,1);

	if($author === false) return false;

	if(!is_numeric($book) && is_integer($author)){
		$sql = "SELECT `id` from `book_books` WHERE name = '".mysql_real_escape_string($book)."' AND `author`= $author LIMIT 1";
		$result = $db->sql_query($sql);
		$db->sql_freeresult($sql);
		$row = $db->sql_fetchrow($result);
		$book = +$row['id'];
	}

	// Return only the specified chapter Metadata and Content if needed
	if(is_integer($chapter)){
		if($content === true && $onlycheck === false) $sql = "SELECT `book`,`name`,`title`,`updated`,`content` FROM `book_chapters` WHERE `book` = '".mysql_real_escape_string($book)."' AND `name` = $chapter LIMIT 1"; // int chapter is, already, INTERGER, and mysql_real_escape_string() is not necesary, too
		elseif($onlycheck === true) $sql = "SELECT `updated` FROM `book_chapters` WHERE `book` = '".mysql_real_escape_string($book)."' AND `name` = $chapter LIMIT 1"; 
		else $sql = "SELECT `book`,`name`,`title`,`updated` FROM `book_chapters` WHERE `book` = '".mysql_real_escape_string($book)."' AND `name` = $chapter LIMIT 1"; // Idem.
		$result = $db->sql_query($sql);
		$db->sql_freeresult($sql);
		$row = $db->sql_fetchrow($result);
	// Return all chapters
	}else{
		$sql = "SELECT `book`,`name`,`title` FROM `book_chapters` WHERE book = '".mysql_real_escape_string($book)."'";
		$result = $db->sql_query($sql);
		$db->sql_freeresult($sql);
		$row = $db->sql_fetchrowset($result);
	}

	if(!empty($row) && $onlycheck === false) return $row;
	if(!empty($row) && $onlycheck === true) return strtotime($row['updated']);
	else return false;

}

/* Update the Chapter
 *
 * update_chapter(), as name suggest, will update the contents of the given Book and Cahpter.
 *
 * Parameters:
 *
 *	* mixed book.
 *	   The name of the Book associated (as String or Integer).
 *
 *	* int chapter
 *	   The chapter number that should be updated.
 *
 *	* string title
 *	   The Title of the chapter.
 *
 *	* string content
 *	   The contents.
 *
 * Returned values
 *
 *	This function will return TRUE if changes were commited successfully,
 *	or FALSE in case of -data, SQL or permissions- error.
 *
*/

// bool update_chapter(mixed book, int chapter, int author, string title, string content)
function update_chapter($book,$chapter,$author,$title,$content){

	global $allowed_edit;

	// Check the permissions 'against any foe'.
	if(!$allowed_edit) return false;

	global $db;

	// Check if book parameter is Integer or String.
	if(!is_integer($book)){
		// Get the ID (INTEGER) of the Book by passing the Name (STRING)
		$sql = "SELECT `id` FROM `book_books` WHERE `name` = '".mysql_real_escape_string($book)."' AND `author` = '".mysql_real_escape_string($author)."'";
		$result = $db->sql_query($sql);
		$book = $db->sql_fetchrow($result);
		$book = $book['id'];
	}
	
	settype($book,'int');
	settype($chapter,'int');
	
	// Set the SQL Query for update.
	$sql = "UPDATE `book_chapters` SET `title` ='".mysql_real_escape_string($title)."' , `content` = '".mysql_real_escape_string(bzcompress($content,9))."', `last_user_update` = '".PHPBB_USER_ID."',`last_update` = 'CURRENT_TIMESTAMP' WHERE `book` = $book AND `name` = $chapter LIMIT 1";

	// Perform the Query to the Database
	$result = $db->sql_query($sql);
	$db->sql_freeresult($sql);
	
	if($result !== false) return true;
	else return false;
}

/* Add a Chapter to the Book
 *
 * add_chapter() will add a chapter Chapter to a given book. This is, add a new line to
 * the List file/Database, and create the Contents file to edit at first time.
 *
 * Parameters:
 *
 *	* string book.
 *	   The name of the Book (see create_book() for naming) 
 *
 *	* string title.
 *	   The title of the chapter (also, see create_book() for naming)
 *
 * Returned values:
 *
 *	This function will return the next chapter as INTEGER (see bellow).
 *	In case of error (file is unaccessable), this function will return FALSE.
 *
 * Observations (File-based only):
 *
 *	In order to get the next chapter, Function should count the lines of the
 *	File using fgetcsv(). Then, List file will be opened twice, first for Read,
 *	and second to Append. an Array with the first field of the List will be obtained,
 *	and the lines will be counted by count().
 *	This method may be non-pretty, but is more safe than count the Contents files instead
 *	using glob(), because the files Content and Comments created have the same names
 *	(foo and foo.comments) and the use of Wildcard will count all the files that
 *	match the pattern.
 *
*/

// int create_chapter(int book,string title)
function add_chapter($book,$title){

	global $db,$loged_in,$allowed_edit;
	
	// Return FALSE if user is not loged in
	if(!$loged_in) return false;

	// :: First, Check if Book exist and get their ID if parameter book is String.

	// If Book parameter is not Integer, assume then parameter is string and get their ID
	if(!is_integer($book)){
		$sql = "SELECT `id` from `book_books` WHERE name = '".mysql_real_escape_string($book)."' LIMIT 1";
		$result = $db->sql_query($sql);
		if($result !== false){
			$book = $db->sql_fetchrow($result);
			$book = $book['id'];
			settype($book,'int');
		}else $book = false;
	// Separated Queries is more secure than use OR in one, man!
	}else{
		$sql = "SELECT `id` from `book_books` WHERE id = '".mysql_real_escape_string($book)."' LIMIT 1";
		$result = $db->sql_query($sql);
		if($result !== false){
			$book = $db->sql_fetchrow($result);
			$book = $book['id'];
			settype($book,'int');
		}else $book = false;
	}

	if(!empty($book) && !empty($title) && $allowed_edit){

		$sql_count = "SELECT `name` from `book_chapters` WHERE book = '".mysql_real_escape_string($book)."' ORDER BY `name` DESC LIMIT 1";
		$result_count = $db->sql_query($sql_count);
		$count = $db->sql_fetchrow($result_count);

		// If result is not empty (at least one chapter exist in the DB)...
		if(!empty($count)) $name = $count['name'] + 1;
		else $name = 1;

		// Then, insert the Chapter metadata in the DB
		$sql = "INSERT INTO `book_chapters` (`author`,`book`,`name`,`title`,`created`,`last_update`,`last_user_update`,`content`) VALUES (".PHPBB_USER_ID.",'".mysql_real_escape_string($book)."', ".mysql_real_escape_string($name).", '".mysql_real_escape_string($title)."', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '".PHPBB_USER_ID."','')";

		$result = $db->sql_query($sql);
		$db->sql_freeresult($sql);
		
		if($result !== false) return $name;
		else return false;
	}else return false;
}

/* Create a Book
 *
 * create_book() will create a new Book. This is, add a new line to the List file/Database of Books.
 *
 * Parameters:
 *
 *  * string name.
 *	The name of the book (see bellow!).
 *
 *  * string title.
 *	The title of the Book (also see bellow).
 *
 *  * string summary
 *	A summary or description of the book/story
 *
 *  * string license
 *	The License(see bellow!).
 *
 * Returned values:
 *
 *	This function will return TRUE if the book were added successfull.
 *	Elsewhere, will return FALSE.
 *
 * Observations:
 *
 *	First, The Name of the book may have only ASCII Alphanumerical characters.
 *	This is not obligatory, but for compatibility with Namespace, Server and Browser, 
 *	the Name will be converted from Title, before calling this Function.
 *	Remember than the Name of Book will be stored in filesystem!
 *
 *	Why not convert the Title to Name inside the Function?
 *	Is simple: To avoid these limitations. URI can contain any characters, 
 *	but is strongly recomended to naming only with Alphanumerical to avoid
 *	problems in Filesystem.
 *
 *	Second, the License details is obtained from get_license()
 *	in /includes/functions/general.php. Here, the type and value of License 
 *	is not important, but in get_license() the parameter license may be Numerical,
 *	but is treated as String. See get_license() for details about treating these data.
 *
 * Fields in CSV file:
 *
 *	string name; string title; string summary; int user_id; string license; int timestamp; bool featured
 *
*/

// bool create_book(string name, string title, string summary,$category[, bool mature[, mixed license]])
function create_book($name,$title,$summary,$category,$lang,$mature = 0,$license = 0){

	global $loged_in;
	if(!$loged_in) return false;

	if(!is_int($category) && !is_bool($mature)) return false;

	global $db;
	
	$user = PHPBB_USER_ID;
	settype($user,'int');
	
	$summary = mb_substr($summary,0,450);
		
	if(empty($mature)) $mature = 0;
	else $mature = 1;
	
	if(empty($license)) $license = 0;
	
	// Check if Book already exist.
	$sql_check = "SELECT `name` from `book_books` WHERE `name` = '".mysql_real_escape_string($name)."' AND `author` = ".mysql_real_escape_string(PHPBB_USER_ID)." LIMIT 1";

	$result_check = $db->sql_query($sql_check);
	if(mysql_num_rows($result_check) !== 0) return false;
	
	$sql = "INSERT INTO `book_books` (`name`,`title`,`summary`,`created`,`author`,`category`,`language`,`mature`,`license`,`last_update`) VALUES ('".mysql_real_escape_string($name)."', '".mysql_real_escape_string($title)."', '".mysql_real_escape_string($summary)."', CURRENT_TIMESTAMP , $user, $category, $lang, $mature, '".mysql_real_escape_string($license)."', CURRENT_TIMESTAMP)";
	$result = $db->sql_query($sql);
	$id = mysql_insert_id();
		
	if($result) return $id;
	else return false;
}

/* Return the Comments published as Array
 *
 * get_comments_chapter() will return the Comments of the Book and Chapter.
 *
 * Parameters
 *
 *	* mixed book
 *	   The name of the Book published
 *
 *	* int chapter
 *	   The chapter published
 *
 *	* mixed author
 *	   The author of the book
 *
 *	* int max
 *	   The maximum comments per page
 *
 *	* int start
 *	   The Offset of comments.
 *
 *
 * Returned values
 *
 *	Return the list of comments as Array.
 *	If no comments are published, or any file required (book or chapter)
 *	does not exist, this function will return FALSE.
 *
 */

// array get_comments_chapter(mixed book, int chapter, int author[, int max = 5[, int page = 0]])
function get_comments_chapter($book,$chapter,$author,$max = 5,$page = 0){

	global $user_admin, $db, $allowed_edit;

	// :: Check and set the variables passed form arguments

	// Set $chapter as INTEGER or return FALSE if is not numeric
	if(is_numeric($chapter)) settype($chapter,'int');
	else return false;
	
	// Book may be INTEGER or STRING. if is numeric, set as INTEGER.
	if(is_numeric($book)) settype($book,'int');

	// Check if $author is Ingeter. if is String, get from the Users table
	if(is_string($author)) $author = get_user($author,1);
	if(is_numeric($author)) settype($author,'int');
	else return false;
	
	// Idem for $chapter above
	if(is_numeric($max)) settype($max,'int');
	else return false;

	// Idem as above	
	if(is_numeric($page)) settype($page,'int');
	else return false;
	
	// :: Check if Book exist
	
	// If Book parameter is not Integer, assume then parameter is string and get their ID
	if(!is_int($book)){
		$sql = "SELECT `id` FROM `book_books` WHERE name = '".mysql_real_escape_string($book)."' AND `author` = '".mysql_real_escape_string($author)."'  LIMIT 1";
		$result = $db->sql_query($sql);
		if($result !== false){
			$book = $db->sql_fetchrow($result);
			$book = $book['id'];
		}else $book = false;
	// Separated Queries is more secure than use OR in one, man!
	}else{
		$sql = "SELECT `id` FROM `book_books` WHERE id = '".mysql_real_escape_string($book)."' AND `author` = '".mysql_real_escape_string($author)."' LIMIT 1";
		$result = $db->sql_query($sql);
		if($result !== false){
			$book = $db->sql_fetchrow($result);
			$book = $book['id'];
		}else $book = false;
	}

	// Check if result form the above Query is not FALSE.
	if(!empty($book) && is_numeric($book)) settype($book,'int');
	else return false;


	// :: Get the total of comments
	
	// Mysql: Two Queries? Are you idiot?
	// Well, to resolv this DILEMA, I'm use a coin and Heads&Tails. if Heads,
	// I'll perform two Queries. If Tails, I'll select all rows of Comments of above Query
	// without Max and Offset.
	// If much comments was published, the ammount of memory will be HUGE and increasing.
	// Otherwise, I'll perform two queries to the DB, one for get the rows and all fields
	// with Max and Offset, and other Query to get all rows, for counting using count().
	// In summary, this is the cost of two Queries, but the ammount of memory to get
	// the fields is reduced drastically. What think you? Is correct this paradigm? 
	// Note: I' using count() because in phpBB does not exist a dedicated SQL function to
	// get the total of fields.

	// Perform the first Query... once if is cached ¬¬	
	if($allowed_edit) $sql_count = "SELECT `id` FROM `book_comments` WHERE `book` = $book AND `chapter` = $chapter ORDER BY `timestamp` DESC";
	else $sql_count = "SELECT `id` FROM `book_comments` WHERE `book` = $book AND `chapter` = $chapter AND (`moderated` = 3 OR `moderated` = 2 OR `moderated` = 1) ORDER BY `timestamp` DESC";
	$result_count = $db->sql_query($sql_count);
	$total = ceil(mysql_num_rows($result_count) / $max);

	// Get the number of pages and check if $page is not greater tha the total pages.
	if($page > 0 && $page <= $total) $page = ($page - 1) * $max;
	else $page = 0;
	
	// :: Get the effective Comments

	// Note: General public should see only the comments that has been approved.
	// The Author or Administrator can see all comments, in order to publish the pending.
	// The comments are Cached, but the Caching is disabled if user is Author or Admin.
	
	if($allowed_edit) $sql = "SELECT `id`,`book`,`chapter`,`user`,`url`,`ip`,`timestamp`,`moderated`,`content` FROM `book_comments` WHERE `book` = $book AND `chapter` = $chapter ORDER BY `timestamp` DESC LIMIT $page, $max";
	else $sql = "SELECT `id`,`book`,`chapter`,`user`,`url`,`timestamp`,`moderated`,`content` FROM `book_comments` WHERE `book` = $book AND `chapter` = $chapter AND (`moderated` = 3 OR `moderated` = 2 OR `moderated` = 1) ORDER BY `timestamp` DESC LIMIT $page, $max";
	$result = $db->sql_query($sql);
	$comments = $db->sql_fetchrowset($result);

	// Return the result.
	if(!empty($comments)) return array($comments,$total);
	else return false;
}

/* Publish a Comment from User or Administrator of a Book and/or Chapter
 *
 * book_post_comment() will publish the comments from user or administrator of a Book and Chapter
 *
 * Parameters
 *
 *  * string book
 *	The name of the Book
 *
 *  * string nick
 *	The user nick (see bellow)
 *
 *  * string email
 *	The valid user's email, for validating
 *
 *  * string comment
 *	The comments (max 500 characters for non registered users, 2000 for registered users
 *	and unlimited for Administrator)
 *
 *  * int chapter (optional)
 *	The Chapter, if comments is associated to a Chapter. If is null, comments is associated to Book
 *
 *  * string url (optional)
 *	A valid URL of Website, or null (see bellow)
 *
 * Returned values:
 *
 *	This function will return TRUE and will register a SESSION variable if 
 *	the comment is saved success. If error ocurred, this function will return
 *	FALSE and will register a SESSION variable.
 *
 * Observations:
 *
 *	In case of registered users (and if phpBB is used) or Administrator is loged-in,
 *	the Nick and Email aren't required; these will be filled automatically BEFORE
 *	calling the Function, by passing them form the Database.
 *
 *	Anonymous User may provide valid URL. Valid URL may contain or not "http://" prefix;
 *	these will be automatically added BEFORE calling the Function. User may not provide
 *	any URL (null) and will be valid too.
 *
 *	In case of registered users (and if phpBB is used), the URL will be the User profile
 *	of the Forum. This destination may not be accessible depending of the privacy of Forum
 *	(only registerd users can see the User's Profile).
 *
 *	Comment published by Anonymous users should be aproved by Administrator. Only comments
 *	published by Registered users and Administrator will be published inmediately.
 *
 *
 * Bugs:
 *
 *	Does not declare the correct Moderated type. Registered users post as Owner!
 *	Registered users still recived the message 'Comments sended but not moderated'.
 *
 *	I'll correct them n.n
 *
*/ 

// bool chapter_post_comment(int chapter, mixed book,mixed author, mixed user[, string url[, int note]])
function book_post_comment($chapter,$book,$author,$user,$comment,$url = null,$note = 2){

	// Set the note as INTEGER
	if(is_numeric($note) && $note <= 4 && $note >=0) settype($note,'int');
	else $note = 2;

	// :: First, check if User exists.

	// Check if Author exist and get their ID if is not given as INTEGER.
	$author_id = get_user($author,1);
	if($author_id === false) return false;

	global $db,$user_admin,$loged_in,$allowed_edit;

	// :: Second, check if Book exists by passing their name as Numeric or STRING.

	// Check if Book exist and get their ID if is not given as INTEGER.
	if(is_numeric($book)) $sql_check = "SELECT `id` FROM `book_books` WHERE `id` = '".mysql_real_escape_string($book)."' AND `author` = $author_id";
	elseif(is_string($book)) $sql_check = "SELECT `id` FROM `book_books` WHERE `name` = '".mysql_real_escape_string($book)."' AND `author` = $author_id";

	$result_check = $db->sql_query($sql_check);
	$book_id = $db->sql_fetchrow($result_check);
	if($book_id !== false) $book_id = $book_id['id'];
	else return false;
	
	settype($book_id,'int');


	// :: Third, validate some data

	if($user_admin) $moderated = MODERATED_ADMIN; // Admin: 3 means special colour in posts
	elseif($author == PHPBB_USER_ID) $moderated = MODERATED_OWNER; // 2 means the Owner
	elseif($loged_in && !$user_admin) $moderated = MODERATED_USER; // Registered user: 1, Post inmediatelly
	else $moderated = MODERATED_ANONYMOUS; // Anonymous user: 0, Moderate comment (Admin will publish them)

	$ip = $_SERVER['REMOTE_ADDR']; // Find X_FORWARDED_FOR!!!
	
	if(preg_match(PREG_URL_STRING,$url) > 0){
		if(strpos($url,"http://") !== false) $url = $url;
		else $url = 'http://' . $url;
	}else $url = null;

	// :: Fourth, perform the SQL Query
	
	$sql = "INSERT INTO `book_comments` (`book`,`chapter`,`author`,`user`,`url`,`ip`,`timestamp`,`moderated`,`note`,`content`)VALUES ($book_id, $chapter, $author_id, '".mysql_real_escape_string($user)."', '".mysql_real_escape_string($url)."', '".mysql_real_escape_string($ip)."',CURRENT_TIMESTAMP,$moderated,$note,'".mysql_real_escape_string(bzcompress($comment))."')";
	$result = $db->sql_query($sql);

	if($result !== false){
	
		// And Fifth, create the File with the Last comment, to avoid call the DB again
		if(!$allowed_edit) @file_put_contents(DPORTAL_ABSOLUTE_PATH.'/stories/.cache/'.sha1($book.$chapter.$author.$ip),time(),LOCK_EX);
		return true;
	}else return false;
}

/* Moderate comments published
 *
 * book_moderate_comments() will publish or delete comments published by any user.
 * 
 * Parameters:
 *
 *	* array id:
 *	   The array of the Comment's ID, provided by the Form. 
 *
 *	* int action:
 *	   Action to take to these comments. Possible values are 0 (Delete) or 1 (Moderate).
 *
 *	* string book:
 *	   The book associated. Only for safety reasosn will be passed
 *
 *	* int chapter:
 *	   The chapter associated (if given). Idem as above.
 *
 * Returned values:
 *
 *	This function will return TRUE if changes are commit to the Comments file,
 *	or FALSE in case of error.
 *
*/

// bool book_moderate_comments(array id, int action, mixed book)
function book_moderate_comments($id,$action,$book){

	global $allowed_edit;

	// Check if Comments file exist, and $id is Array.
	if(!is_array($id) || !$allowed_edit) return false;

	global $db;
	
	switch($action){
		// Delete comment
		case 0:
			foreach($id as $getid){
				$sql = "DELETE FROM `book_comments` WHERE `book_comments`.`id` = $getid";
				$result = $db->sql_query($sql);
				if($result === false) return false;
			}
			break;
		// Publish comment pending
		case 1:
			foreach($id as $getid){
				$sql = "UPDATE `book_comments` SET `moderated` = '1' WHERE `book_comments`.`id` = $getid AND `book_comments`.`moderated` = 0";
				$result = $db->sql_query($sql);
				if($result === false) return false;
			}
			break;
	}

	return true;
}

/* Check if user is allowed to edit their (own) story.
 *
 * book_allowed_edit() will check if the user can edit, add or create stories and chapters.
 * The user can be the owner of the story, or the Administrator.
 *
 * Parameters:
 *
 *	* mixed book:
 *	   The Book/Story
 *
 *	* int author:
 *	   The User ID (see bellow)
 *
 * Returned values:
 *
 *	This function will return TRUE if the given user ID matchs with the owner's ID.
 *
 *	If user is Administrator, ALWAYS will return true.
 *
 *	If Book does not exist, this means than the User is attemped to Create the Book.
 *	In this case, return TRUE.
 *
 *	Elsewhere, this function will return FALSE
 *
 * Observations:
 *
 *	Owner is obtained from the Book list. These value is Integer. When phpBB is used,
 *	the phpBB User ID is used and stored in the list. If not, the ID is 1, that represents
 *	the Administrator's username.
 *
 * Warning:
 *
 *	If you aren't using phpBB and later you think to use them, or viceversa, the ID
 *	stored does not change. If ID is 0, the user allowed is Anonymous!!!
 *
*/
 

// bool book_allow_edit(mixed book,mixed user_id)
function book_allowed_edit($book,$author){

	global $loged_in, $user_admin;
	
	if(!$loged_in) return false;
	if($user_admin) return true; // Return TRUE uncondionately if user is Admin

	// Check if Author exists and Get the User ID if parameter $author is String	
	$author = get_user($author,1);
	if($author === false) return false;
	
	
	
	if(is_numeric($book)) settype($book,'int');

	global $db;
	
	// Set the SQL Query and perform the Query.
	if(is_integer($book)) $sql = "SELECT `author` FROM `book_books` WHERE `id` = '$book' AND `author` = $author LIMIT 1";
	elseif(is_string($book)) $sql = "SELECT `author` FROM `book_books` WHERE `name` = '$book' AND `author` = $author LIMIT 1";
	$result = $db->sql_query($sql);
	$id_db = $db->sql_fetchrow($result);
	if(!empty($id_db)) $id_db = $id_db['author'];
	else return false; // User aor Book does not exist. return FALSE.

	// Return TRUE if current User ID matchs with the Author passed.
	if($id_db == PHPBB_USER_ID) return true;
	else return false;
}

// bool store_read_chapter(string book,int chapter, int author)
function store_read_chapter($book,$chapter,$author){

	// Before anything, check the User Agent

	// ~~~

	$ip = $_SERVER['REMOTE_ADDR'];
	$user = PHPBB_USER_ID;
	settype($user,'int');

	if(!is_numeric($author)) get_user($author,1);
	settype($author,'int');
	
	if(is_numeric($chapter)) settype($chapter,'int');
	else return false;

	global $db;

	// Check if Book exist and get their ID if is not given as INTEGER.
	if(!is_integer($book)){
		$sql = "SELECT `id` FROM `book_books` WHERE `name` = '".mysql_real_escape_string($book)."'";
		$result = $db->sql_query($sql);
		$book = $db->sql_fetchrow($result);
		if($book !== false) $book = $book['id'];
		else return false;
	}
	
	settype($book,'int');
	
	$sql = "INSERT INTO `book_reads` (`book`,`chapter`,`author`,`ip`,`user`,`timestamp`) VALUES ($book, $chapter, $author, '$ip',$user, CURRENT_TIMESTAMP)";

	if($db->sql_query($sql) !== false) return true;
	else return false;
}

/* Check if Anonymous user is allowed to post, based on the IP and last post
 *
 * This functions is currently in Building.
 *
 *
function check_allowed_post(string ip, int timestamp){
 
 die('Building function...');
 
} */
 
 
 
/* Return the Points acumulated of a given Author (and) Book
 *
 * get_points() is a function designed to get the Points from an Author,
 * and optionally, a Book created by them. See Observations bellow for details.
 *
 * Parameters:
 *
 *	* mixed author
 *	   The author. May be String (Username given) or Integer (User ID given).
 *
 *	* mixed book
 *	   The Book. If given, get only the points from the specific Book.
 *
 *	* bool already_checked
 *	   If the parameters above has been already checked outer the Function (generally called
 *	   from another Function that checked the parameters, avoid perform these checks again.
 *
 *
 * Returned values:
 *
 * This function will return the Points obtained from the Reads and Comments tables as INTEGER.
 * If no Reads has been done, this function will return INT 0 (note than, in order to get
 * the Comments, necesary exist Reads stored in DB; if no reads, Fuction will return 0 there).
 * If error occurs (Author or Book does not exist), this function will return FALSE.
 *
 *
 * Observations: 
 *
 *	Points are given from two sources: Reads table and Comments table.
 *
 *	Once obtained from the Query, the reads should be filtered to count only valid Reads.
 *	This is, Reads will be counted only with a delay of X time (default one hour).
 *	In simple words, reads done under one hour, or repetidelly loads of page will be
 *	stored, but not considered. Reads from Author or Admin will not be considered, too.
 *
 *	Second source is the Comments table. Here, the user has the option to cualiffy the
 *	chapter as the following:
 *
 *		4.- Awesome!	
 *		3.- Great   
 *		2.- Interesting (default)
 *		1.- Not so bad
 *		0.- You suck!
 *
 *	In this case, the Note is considered and added to the Points obtained above.
 *	Only the valid Comments will be considered; Author or Admin or non-moderated
 *	comments should not be considered.
 *	Note than, if Author or Admin delete the comments, the points associated will
 *	be deleted and discounted, too.
 *
 *
 * Warning:
 *
 *	This function appears simple, but in Production with hundreds or millions of registers,
 *	may use huge ammount of resources. Be carefull and use other methods for calling.
 *
 *	I recommended to use update_points_book_table() to perform the count and store the
 *	data in the DB. See update_points_book_table() for details. 
 *
 */
 
// int get_points(mixed author[, mixed book[,bool already_checked = false]])
function get_points($author,$book,$already_checked = false){

	global $db, $user_admin;
	
	// Avoid to perform the checks if them already has been done.
	if($already_checked === true){

		// Get the IF form the Author, or check if exist.
		$author = get_user($author,1);
		if(empty($author)) return false;
	
		settype($author,'int');

		// Check if Book exist, and if is String, get their ID.
		if(!empty($book)){
			if(is_numeric($book)) $sql_check = "SELECT `id` FROM `book_books` WHERE `id` = $book AND `author` = $author LIMIT 1";
			elseif(is_string($book)) $sql_check = "SELECT `id` FROM `book_books` WHERE `name` = '".mysql_real_escape_string($book)."' AND `author` = $author LIMIT 1";
			else return false;
			$result_check = $db->sql_query($sql_check);
			$rows_check = $db->sql_fetchrow($result_check);
			if(!empty($rows_check)) $book = $rows_check['id'];
			else return false;
		
			settype($book,'int');
		}
	}
	
	
	
	// Query for Absolute read and Filter.

	// First, We perform the SQL Query, ordering by IP and Timepstamp
	if(!empty($book)) $sql_reads = "SELECT `ip`,`timestamp`,`author` FROM `book_reads` WHERE `author` = $author AND `book` = $book ORDER BY `timestamp` DESC";
	else $sql_reads = "SELECT `ip`,`timestamp`,`author` FROM `book_reads` WHERE `author` = $author ORDER BY `timestamp` DESC";
	$result_reads = $db->sql_query($sql_reads);
	$row_reads = $db->sql_fetchrowset($result_reads);
	$num_books = count($row_reads);

	// Check if the result is not empty. If them, return 0 and break here.
	if(empty($row_reads)) return 0;

	// First, get the Rows and set an Array with IP and Num incrermental as Key (see bellow)
	foreach($row_reads as $row){

		// Get the variablles from Row
		$ip = $row['ip'];
		$timestamp = strtotime($row['timestamp']);
		
		// If current IP is different than the Last IP, rewind the Num Key to 0
		// (first time to itearte, Num Key is 0 by default, because Last IP is null).
		if($ip != $last_ip) $num = 0;
		
		// Don't consider the reads from Owner or Admin
		//if($author != $row['author'] || !$user_admin) $row_reads_largestring[$ip] .= strtotime($row['timestamp']).';'; // First method, CSV String
		if($author != $row['author'] || !$user_admin) $row_reads_filtered[$ip][$num] = $timestamp; // New method, Array with IP and Num as Keys
		$num++; // Increment Num Key
		$last_ip = $ip; // Set Last IP to compare to the next
	}
	
	//if(empty($row_reads_largestring)) return false; // Deprecated
	if(empty($row_reads_filtered)) return false;

	// Unset unused array
	unset($row_reads);

/* Deprecated

	// Here I'll re-merge the String delimited using explode() effectivelly get Arrays
	// with the Key and multiple values (the Timestamps). Unfortunadely, the last
	// value will be NULL, and this should be corrected later, in third foreach.
	foreach($row_reads_largestring as $key=>$value){
		$ip = $key;
		if(!empty($value)) $row_reads_filtered[$ip] = explode(";",$value);
	}
	
	// Unset unused array
	unset($row_reads_largestring);
*/	

	// And finally, with the Multidimensional Array give above, now I can filter and count!
	// The hardest, is create a name for Variables and write proper comments xD
	foreach($row_reads_filtered as $row){
		foreach($row as $row_filter){
			// Increment Points ONLY if the same IP loads the page upon 1 hour.
			if((($last_timestamp - $row_filter) > 3600)) $num++;
			$last_timestamp = $row_filter;
		}
	}
	
	// Unset unused array
	unset($row_reads_filtered);
	
	// :: Query for Comments
	
	// Set the SQL Query
	if(!empty($book)) $sql_comments = "SELECT `user`,`note` FROM `book_comments` WHERE `author` = $author AND `book` = $book AND `moderated` = 1 ORDER BY `timestamp` DESC";
	else $sql_comments = "SELECT `note`,`user` FROM `book_comments` WHERE `author` = $author AND `moderated` = 1 ORDER BY `timestamp` DESC";
	$result_comments = $db->sql_query($sql_comments);
	$row_comments = $db->sql_fetchrowset($result_comments);
	
	// Add the Note of Comments to the Points to get the final result (default: 2).
	foreach($row_comments as $row){
		// Don't count comments from the same Author or Admin.
		if($row['user'] != $author || !$user_admin) $num = $num + $row['note'];
	}

	// Unset unused array
	unset($row_comments);
	
	// If the return is the User's General Points (points from All books)
	// add the points of the number of Books multiplied by 10 (3 books, 30 points more).
	if(empty($book)) $num = $num + ($num_books * 10);
	
	// Return the value
	return $num;
}


/* Get the points from an Author and Book, and store to `book_books` (Books table).
 *
 * update_points_book_table() is a function to call get_points()
 * and store the result into de the table `book_books`. This function is designed to
 * call get_points() only each 12 hours; under 12 hours will refuse call get_points()
 *
 * Parameters:
 *
 *	mixed author
 *	   The Author
 *
 *	mixed book
 *	   The Book to be updated
 *
 * Returned values
 *
 *	This function will return TRUE if update has been performed successfully, or
 *	FALSE if refused to call get_points(), or in case of error.
 *
 *
 * Observations:
 *
 *	He should avoid to call get_points() every moment; call should be done
 *	every 12 hours. Chceck `last_update` in `book_books` and compare with the
 *	corrent Timestamp. If time passed is greater the 12 hours, call get_points().
 *	Elsewhere, return something... but I'm still tinkink what vaule return, FALSE or not.
 *	Why? Because get_points uses three foreach to get, filter and return the data,
 *	and in Production... better don't explain xD
 *
 */

// bool update_points_book_table(mixed author, mixed book)
function update_points_book_table($author,$book,$force_update = false){

	// :: First, check if Book exist and get the Last Update
	
	// Get the ID form the Author, or check if exist.
	$author = get_user($author,1);
	if(empty($author)) return false;
	
	global $db;
	
	// Check if Book exist, and if is String, get the Last Update Timestamp.
	if(is_numeric($book)) $sql_check = "SELECT `id`,`last_update` FROM `book_books` WHERE `id` = $book AND `author` = $author LIMIT 1";
	elseif(is_string($book)) $sql_check = "SELECT `id`,`last_update` FROM `book_books` WHERE `name` = '".mysql_real_escape_string($book)."' AND `author` = $author LIMIT 1";
	else return false;
	$result_check = $db->sql_query($sql_check);
	$rows_check = $db->sql_fetchrow($result_check);
	if(!empty($rows_check)){
		$last_update = strtotime($rows_check['last_update']);
		$book = $rows_check['id'];
	}
	else return false;
	
	settype($last_update,'int');
	$curr_timestamp = time();
	
	// Check the Last Update against the Current Timestamp. Perform only every 12 hours.
	if($force_update != true){
		if(($curr_timestamp - $last_update) < 43200) return false; // Refused
	}
	
	// :: Second, call get_points()
	
	// Call get_poins()
	$points = get_points($author,$book);
	if(empty($points)) return false;

	
	// :: Third, store the points in the DB
	
	$sql_put = "UPDATE `book_books` SET `points` = '$points', `last_update` = CURRENT_TIMESTAMP WHERE `author` = $author AND `id` = $book";
	$result_put = $db->sql_query($sql_put);
	
	if($result_put !== false) return true;
	else return false;
}

/* Get all the Points acumulated form Author (from the Books table)
 *
 * get_all_points_author() will get the points form every Book from Author, 
 * and add some points for each Book created from Author.
 *
 * This operation is done in two ways: Reading the fileds `points` table `book_books` from
 * every Book, and in real time, reading the Reads and Comment, identical as get_points()
 * 
 *
 *
 *
 *
 *
 *
 */

// mixed get_categories([mixed category[, string genere]])
function book_get_categories($category = null,$genere = null,$as_id = false){

	global $db, $LANG;
	
	if(is_numeric($category)) settype($category,'int');

	if((!empty($category) && is_string($category) && !empty($genere) && is_string($genere)) || is_integer($category)){
	
		$prefix = 'book_gen_';

		if(is_integer($category)) $sql = "SELECT * FROM `book_categories` WHERE `id` = $category LIMIT 1";
		else $sql = "SELECT * FROM `book_categories` WHERE `category` = '".mysql_real_escape_string($category)."' AND `genere` = '".mysql_real_escape_string($genere)."' LIMIT 1";

		$result = $db->sql_query($sql);
		$count = mysql_num_rows($result);
		if(empty($count)) return false;
		$row = $db->sql_fetchrow($result);
		
		$langvar = $prefix . $row['category'] . '_' . $row['genere'];
		
		// Return an Array with the Name translated and the ID
		$return = array($LANG[$langvar],$row['category'].'_'.$row['genere'],$row['id']);
		
		return $return;
		
	}elseif(is_string($category) && empty($genere)){
	
		$prefix = 'book_cat_';
	
		$sql = "SELECT * FROM `book_categories` WHERE `category` = '".mysql_real_escape_string($category)."' LIMIT 1";
		$result = $db->sql_query($sql);
		$count = mysql_num_rows($result);
		if(empty($count)) return false;
		$row = $db->sql_fetchrow($result);
		$langvar = $prefix . $category;
		return $LANG[$langvar];
	
	}elseif((empty($category) || $category == true) && empty($genere)){

		$sql = "SELECT * FROM `book_categories`";
		$result = $db->sql_query($sql);
		$count = mysql_num_rows($result);
		if(empty($count)) return false;
		$rows = $db->sql_fetchrowset($result);

		foreach($rows as $row){
			$id = $row['id'];
			$category = $row['category'];
			$genere = $row['genere'];

			$categories_db[$category][$id] = $genere;
		}
		
		// Types: 0, Select; 1, Category; 2, Genere.
		
		$count = 0;
		$categories[] = array('id'=>0,'string'=>$LANG['book_cat_select'],'type'=>0);
		foreach($categories_db as $key=>$value){
		
			asort($value,SORT_STRING);
		
			if($category == true) $categories[] = array('id'=>$count,'string'=>'::'.$LANG['book_cat_'.$key].'::','type'=>1);
			else $categories[] = array('id'=>$count,'string'=>$LANG['book_cat_'.$key],'type'=>1);
			foreach($value as $key2=>$value2){
				if($category == true) $categories[] = array('id'=>$key2,'string'=>'&nbsp;&nbsp;*&nbsp;'.$LANG['book_gen_'.$key.'_'.$value2],'type'=>2);
				else $categories[] = array('id'=>$key2,'string'=>$LANG['book_gen_'.$key.'_'.$value2],'type'=>2);
			}
			$count++;
		}
		
		return $categories;
	}else return false;
}



// mixed book_get_langs([string name[, bool id]])
function book_get_langs($name = null,$as_id = false){

	global $db, $LANG, $lang;
	
	$prefix = 'book_lang_';

	if(!empty($name)){
		$sql = "SELECT `id`,`name` FROM `book_language` WHERE `name` = '".mysql_real_escape_string($name)."' LIMIT 1";

		$result = $db->sql_query($sql);
		$count = mysql_num_rows($result);
		if(empty($count)) return false;
		$row = $db->sql_fetchrow($result);
		
		$langvar = $prefix . $row['name'];
		$id = $row['id'];
		
		if($as_id == true) return $id;
		else return $LANG[$langvar];
	}else{	
		$sql = "SELECT `id`,`name` FROM `book_language`";

		$result = $db->sql_query($sql);
		$count = mysql_num_rows($result);
		if(empty($count)) return false;
		$rows = $db->sql_fetchrowset($result);
		
		foreach($rows as $row){
			$id = $row['id'];
			$name = $row['name'];
			$langrow = $prefix . $name;
			$langvar[$id] = array('name'=>$name,'string'=>$LANG[$langrow]);
		}
		
		return $langvar;
	}
}

// array book_search(string keywords[, int search_for[, int category[, int points, bool mature]]])
function book_search($keywords,$search_for = 0,$category = null,$lang = null,$points = null,$mature = 0,$page = null){

	if(!is_numeric($search_for)) $search_for = 0;

	if(empty($category) || !is_numeric($category)) $category = 'NULL';
	else settype($category,'int');
	
	if(empty($lang) || !is_numeric($lang)) $lang = 'NULL';
	else settype($lang,'int');
	
	if(empty($points) || !is_numeric($points)) $points = 'NULL';
	else settype($points,'int');
	
	if(empty($mature) || !is_numeric($mature)) $mature = 'NULL';
	else settype($mature,'int');

	if(is_numeric($page)) settype ($page,'int');
	else $page = 1;

	if($page <= 1 || !is_integer($page)) $page = 1;
	if(empty($page)) $start = 0;
	
	$start = 20 * $page - 1;

	global $db;

	// Search for Story
	if($search_for == 0 || $search_for == 1){
		$sql ="SELECT `name`,`title`,`author`,`summary` FROM `book_books` WHERE (`title` LIKE '%".mysql_real_escape_string($keywords)."%' OR ($search_for = 1 AND (`summary` LIKE '%".mysql_real_escape_string($keywords)."%' OR '".mysql_real_escape_string($keywords)."' IS NULL))) AND (`category` = $category OR $category IS NULL) AND (`language` = $lang OR $lang IS NULL) AND (`points` >= $points OR $points IS NULL) AND (`mature` = $mature OR $mature IS NULL)";

echo $sql;

		$result = $db->sql_query($sql);
		$count = mysql_num_rows($result);
		if(empty($count)) return false;
		elseif($count == 1){
			$row = $db->sql_fetchrow($result);
			return array('type'=>SR_STORY,'value'=>$row);	
		}elseif($count > 1){
			$row = $db->sql_fetchrowset($result);
			return array('type'=>SR_STORIES,'value'=>$row);
		}else return false;
		
	// Search for Author
	}elseif($search_for == 2){
		$user = get_user($keywords,true);
		// Results of Search for Author
		if(is_array($user) && count($user) > 1) return array('type'=>SR_AUTHORS,'value'=>$user);
		elseif(is_string($user)) return array('type'=>SR_AUTHOR,'value'=>$user);
		else return false;
	}
}

// int book_comments_get_remaning()
function book_comments_get_remaning($book,$chapter,$author,$greace_period = 900,$ip = null,$curr_timestamp = null){

	if($greace_period === false) return true;

	if($ip == null) $ip = $_SERVER['REMOTE_ADDR'];
	if($curr_timestamp == null) $curr_timestamp = time();
	if(!is_int($greace_period) || empty($greace_period)) $greace_period = 900;
	
	$file = DPORTAL_ABSOLUTE_PATH.'/stories/.cache/'.sha1($book.$chapter.$author.$ip);
	if(is_file($file) && is_readable($file)) $timestamp = file_get_contents($file);
	
	$remaning = ($timestamp + $greace_period) - $curr_timestamp;
	
	if($remaning > 0) return $remaning;
	else return true;
}

// The largest name of a Function!
// I'm thinking how to alert to Author than have Comments pending for Moderation.
// I'm finding forms to do them. The idea is not alert for each Comments, instead, 5 or 10
// comments pending will trigger the PM/Email alerting than the Book has them.
// An laternative to avoid Trigger repetidelly (whan users publish ans publish comments and
// Author does not moderate them, in `book_chapter` I'll put other column that will be a
// Flag, for Comments that are pendig for Moderation. if is True, means the Alert is sended.
// Mmm... I still thinking...
function send_private_message_comments_moderate_pending($author,$book,$chapter,$mode = null){
	// Currently, Function does not return nothing.
	return null;
}



// bool alert_pending_pm
function alert_pending_pm($userid) {
	include_once(PHPBB_ROOT_PATH.'includes/functions_privmsgs.php');
	
	$message = utf8_normalize_nfc($pmmessage);
	$uid = $bitfield = $options = ''; // will be modified by generate_text_for_storage
	$allow_bbcode = false;
	$allow_smilies = false;
	$allow_urls = true;
	
	$message = "Hola";
	
	generate_text_for_storage($message, $uid, $bitfield, $options, $allow_bbcode, $allow_urls, $allow_smilies);
	$pm_data = array(
	'from_user_id'        => PHPBB_USER_ID,
	'from_user_ip'        => "127.0.0.1",
	'from_username'        => PHPBB_USERNAME,
	'enable_sig'            => false,
	'enable_bbcode'        => false,
	'enable_smilies'        => false,
	'enable_urls'        => true,
	'icon_id'            => 0,
	'bbcode_bitfield'    => $bitfield,
	'bbcode_uid'         => $uid,
	'message'            => $message,
	'address_list'        => array('u' => array($userid => 'to')),
	);
	
	$pmsubject = 'No';
	 
	//Now We Have All Data Lets Send The PM!!
	$submit = submit_pm('post', $pmsubject, $pm_data, false, false);
	
	var_dump($submit);
	
}

?>