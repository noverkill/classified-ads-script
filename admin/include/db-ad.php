<?php
/**
 * Classified-ads-script
 *
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @version    $Id: db-ad.php
 */

/**
 * The MySQL table interface for the Ad table
 */
class Ad extends Table{

	/**
	 * The name of the MySQL table
	 *
	 * @var string
	 */
	protected static $table_name = 'ad';
	
	/**
	 * The array of the MySQL table's column names
	 *
	 * @var string
	 */
	protected static $table_columns = 'user_id, name, email, telephone, title, description, picture, category, price, city, region, postedon, expiry, webpage, order, active, code, activedon, sponsored, sponsoredon, expirednotice, ipaddr, lastmodified';
	
	/**
	 * The default order e.g. 'ORDER BY id DESC'
	 *
	 * @var string
	 */
	protected static $default_order = 'ORDER BY sponsored DESC, lastmodified DESC';


	/**
	 * Get all records from the ad regarding the given filters
	 * Set the picture and thumb value for every record.
	 * 
	 * @param 	array 	$filters[optional]			Key value pairs for filtering the result.
	 * @param 	string 	$text_filter[optional]		Sql expression needs to be inserted to the WHERE clause of the query.
	 * @param 	int 	$limit[optional]			Number of rows needs to be returned.
	 * @param 	string 	$order_by[optional]			The designated row order. If not given then the table's default order vill be used.
	 * @return 	array 								The result rows as array.
	 */
	static public function get_all ( $filters = array(), $text_filter = '', $limit = '', $order_by = '' ) {

		global $db, $upload_path;
						
		$filter = '';	
		foreach( $filters as $key => $value )  $filter .= " AND $key='$value'";
				
		if( $text_filter != '' ) $text_filter = "AND $text_filter";

		if ($order_by == '' ) $order_by = static::$default_order;
				
		if( $limit != '' ) $limit = "LIMIT $limit";
		
		$db->sql = "SELECT  id,name,email,title,description,price,telephone,webpage,picture,city,
		                    postedon,lastmodified,expiry,code,active,sponsored,sponsoredon,     
					(SELECT r.parent FROM category r WHERE r.id=category) as category_parent,
					(SELECT r.id FROM category r WHERE r.id=category) as category_id1, 
					(SELECT r.id FROM category r WHERE r.id=category_parent) as category_id2,
					(SELECT IF(category_parent=0,category_id1,category_id2)) as main_category_id,
					(SELECT IF(category_parent=0,0,category_id1)) as sub_category_id,
					(SELECT r.name FROM category r WHERE r.id=main_category_id) as main_category,
					(SELECT r.slug FROM category r WHERE r.id=main_category_id) as main_category_slug,
					(SELECT r.name FROM category r WHERE r.id=sub_category_id) as sub_category,
					(SELECT r.slug FROM category r WHERE r.id=sub_category_id) as sub_category_slug,
					(SELECT r.parent FROM region r WHERE r.id=region) as region_parent,
					(SELECT r.id FROM region r WHERE r.id=region) as region_id1, 
					(SELECT r.id FROM region r WHERE r.id=region_parent) as region_id2,
					(SELECT IF(region_parent=0,region_id1,region_id2)) as main_region_id,
					(SELECT IF(region_parent=0,0,region_id1)) as sub_region_id,
					(SELECT r.name FROM region r WHERE r.id=main_region_id) as main_region,
					(SELECT r.slug FROM region r WHERE r.id=main_region_id) as main_region_slug,
					(SELECT r.name FROM region r WHERE r.id=sub_region_id) as sub_region,
					(SELECT r.slug FROM region r WHERE r.id=sub_region_id) as sub_region_slug
					FROM ".static::$table_name." h
					WHERE 1=1 $filter $text_filter
					$order_by 
					$limit";		
		$db->query();

		$ads = array ();	
		while( $row = mysqli_fetch_array( $db->rs ) ) {		
			
			if ($row['picture'] != '') {
				$picture = $upload_path . '/' . str_replace('-','/',$row['postedon']) . '/picture/' . $row['picture']; 
				$thumb  = $upload_path . '/' . str_replace('-','/',$row['postedon']) . '/thumb/thumb_' . $row['picture'];
			} else {
				$picture = './images/nopicture.gif';
				$thumb   = './images/nopicture.gif'; 
			}
			
			$row['picture'] = $picture;		
			$row['thumb']   = $thumb;
			
			$row['pricec']  = str_to_currency ( $row['price'] );
			$row['weblink'] = create_web_link ( $row['webpage'], '_blank');
			$row['emailto'] = create_mail_link( $row['email']);
			
			$ads[] = $row;
		}
		
		return $ads;
	}

	/**
	 * Activate the ad
	 *
	 * @param int 		$id					The ad's id.
	 * @param string 	$code[optional]		The ad's activation code.
	 */
	static public function activate ($id, $code = '') {
		
		global $db;
		
		if( $code != '' ) $code = "AND code='" . escape( $code ) . "'";

		$db->sql = sprintf( "UPDATE ".static::$table_name." 
		                     SET active='1',activedon=NOW(),lastmodified=NOW() 
		                     WHERE id=%d $code", 
		                     $id );
		$db->query();	
		
		return mysqli_affected_rows( $db->rs );
	}
	
	/**
	 * Update record in the ad table. 
	 *
	 * @param int 		$id					The ad's id.
	 * @param array 	$fields				Column-name => value pairs for updating.
	 * @param string 	$code[optional]		The ad's activation code.
	 */
	static public function update( $id, $fields, $code = '' ) {

		global $db;
		
		if( $code != '' ) $code = "AND code='" . escape( $code ) . "'";
				
		$update = '';
		foreach( $fields as $key => $value ) {
			if( $key == 'extend') $update .= sprintf( "expiry=ADDDATE(expiry,%d),", $value );
			else $update .= "$key='" . escape( $value ) . "',";	
		}
		
		if ($update != '') {				

			$db->sql = sprintf( "UPDATE ".static::$table_name."
						         SET $update lastmodified=NOW() 
						         WHERE id=%d $code",
						         $id );					   
			$db->query(); 
		}
	}
}

?>
