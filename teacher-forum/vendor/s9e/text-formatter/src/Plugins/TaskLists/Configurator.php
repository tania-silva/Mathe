<?php declare(strict_types=1);

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2020 The s9e authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Plugins\TaskLists;

use s9e\TextFormatter\Configurator\Items\Tag;
use s9e\TextFormatter\Plugins\ConfiguratorBase;

class Configurator extends ConfiguratorBase
{
	/**
	* {@inheritdoc}
	*/
	public function asConfig()
	{
		return;
	}

	protected function setUp(): void
	{
		if (!isset($this->configurator->tags['LI']))
		{
			$this->configurator->Litedown;
		}

		$this->createTaskTag();
		$this->configureListItemTag($this->configurator->tags['LI']);
	}

	protected function configureListItemTag(Tag $tag): void
	{
		$tag->filterChain->append(Helper::class . '::filterListItem')
			->resetParameters()
			->addParameterByName('parser')
			->addParameterByName('tag')
			->addParameterByName('text')
			->setJS(file_get_contents(__DIR__ . '/filterListItem.js'));

		$tag->template = preg_replace(
			'(<li[^>]*+>(?!<xsl:if test="TASK">)\\K)',
			'<xsl:if test="TASK">
				<xsl:attribute name="data-s9e-livepreview-ignore-attrs">
					<xsl:text>data-task-id</xsl:text>
				</xsl:attribute>
				<xsl:attribute name="data-task-id">
					<xsl:value-of select="TASK/@id"/>
				</xsl:attribute>
				<xsl:attribute name="data-task-state">
					<xsl:value-of select="TASK/@state"/>
				</xsl:attribute>
			</xsl:if>',
			$tag->template
		);
	}

	protected function createTaskTag(): void
	{
		$tag = $this->configurator->tags->add('TASK');
		$tag->attributes->add('id')->filterChain->append('#identifier');
		$tag->attributes->add('state')->filterChain->append('#identifier');
		$tag->template = '<input data-task-id="{@id}" data-s9e-livepreview-ignore-attrs="data-task-id" type="checkbox">
			<xsl:if test="@state = \'checked\'"><xsl:attribute name="checked"/></xsl:if>
			<xsl:if test="not($TASKLISTS_EDITABLE)"><xsl:attribute name="disabled"/></xsl:if>
		</input>';
	}
}