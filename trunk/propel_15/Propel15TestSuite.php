<?php

require_once dirname(__FILE__) . '/../AbstractTestSuite.php';

class Propel15TestSuite extends AbstractTestSuite
{
	function initialize()
	{
		set_include_path(
			realpath(dirname(__FILE__) . '/build/classes') . PATH_SEPARATOR .
			realpath(dirname(__FILE__) . '/vendor/propel/runtime/lib') . PATH_SEPARATOR .
			get_include_path()
		);

		require_once 'Propel.php';
		$conf = include realpath(dirname(__FILE__) . '/build/conf/bookstore-conf.php');
		$conf['log'] = null;
		Propel::setConfiguration($conf);
		Propel::initialize();
		Propel::disableInstancePooling();
		
		$this->con = Propel::getConnection('bookstore');
		$schemaSQL = file_get_contents(dirname(__FILE__) . '/build/sql/schema.sql');
		$this->con->exec($schemaSQL);
	}
	
	function clearCache()
	{
		BookPeer::clearInstancePool();
		AuthorPeer::clearInstancePool();
	}
	
	function beginTransaction()
	{
		$this->con->beginTransaction();
	}
	
	function commit()
	{
		$this->con->commit();
	}
	
	function runAuthorInsertion($i)
	{
		$author = new Author();
		$author->setFirstName('John' . $i);
		$author->setLastName('Doe' . $i);
		$author->save($this->con);
		$this->authors[]= $author->getId();
	}

	function runBookInsertion($i)
	{
		$book = new Book();
		$book->setTitle('Hello' . $i);
		$book->setAuthorId($this->authors[array_rand($this->authors)]);
		$book->setISBN('1234');
		$book->save($this->con);
		$this->books[]= $book->getId();
	}
	
	function runPKSearch($i)
	{
		$author = AuthorQuery::create()
			->findPk($this->authors[array_rand($this->authors)], $this->con);
	}
	
	function runSearch($i)
	{
		$authors = AuthorQuery::create()
			->where('Author.Id > ?', $this->authors[array_rand($this->authors)])
			->limit(5)
			->find($this->con);
	}
	
	function runJoinSearch($i)
	{
		$books = BookQuery::create()
			->filterByTitle('Hello' . $i)
			->leftJoinWith('Book.Author')
			->findOne($this->con);
	}
	
}