<?php
namespace craft\app\records;

/**
 * Class AssetFile record.
 *
 * @todo Create save function which calls parent::save and then updates the meta data table (keywords, author, etc)
 *
 * @author    Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @copyright Copyright (c) 2014, Pixel & Tonic, Inc.
 * @license   http://buildwithcraft.com/license Craft License Agreement
 * @see       http://buildwithcraft.com
 * @package   craft.app.records
 * @since     1.0
 */
class AssetFile extends BaseRecord
{
	// Public Methods
	// =========================================================================

	/**
	 * @inheritDoc BaseRecord::getTableName()
	 *
	 * @return string
	 */
	public function getTableName()
	{
		return 'assetfiles';
	}

	/**
	 * @inheritDoc BaseRecord::defineRelations()
	 *
	 * @return array
	 */
	public function defineRelations()
	{
		return array(
			'element' => array(static::BELONGS_TO, 'Element', 'id', 'required' => true, 'onDelete' => static::CASCADE),
			'source'  => array(static::BELONGS_TO, 'AssetSource', 'required' => false, 'onDelete' => static::CASCADE),
			'folder'  => array(static::BELONGS_TO, 'AssetFolder', 'required' => true, 'onDelete' => static::CASCADE),
		);
	}

	/**
	 * @inheritDoc BaseRecord::defineIndexes()
	 *
	 * @return array
	 */
	public function defineIndexes()
	{
		return array(
			array('columns' => array('filename', 'folderId'), 'unique' => true),
		);
	}

	// Protected Methods
	// =========================================================================

	/**
	 * @inheritDoc BaseRecord::defineAttributes()
	 *
	 * @return array
	 */
	protected function defineAttributes()
	{
		return array(
			'filename'		=> array(AttributeType::String, 'required' => true),
			'kind'			=> array('column' => ColumnType::Varchar, 'maxLength' => 50, 'required' => true, 'default' => 'unknown'),
			'width'			=> array(AttributeType::Number, 'min' => 0, 'column' => ColumnType::SmallInt),
			'height'		=> array(AttributeType::Number, 'min' => 0, 'column' => ColumnType::SmallInt),
			'size'			=> array(AttributeType::Number, 'min' => 0, 'column' => ColumnType::Int),
			'dateModified'	=> AttributeType::DateTime
		);
	}
}