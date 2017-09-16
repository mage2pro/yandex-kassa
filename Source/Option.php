<?php
namespace Dfe\YandexKassa\Source;
// 2017-09-16
/** @method static Option s() */
final class Option extends \Df\Config\Source {
	/**
	 * @override
	 * @see \Df\Config\Source::map()
	 * @used-by \Df\Config\Source::toOptionArray()
	 * @return array(string => string)
	 */
	protected function map() {return df_sort_names(df_map(function(array $a) {return dfa_deep(
		$a, 'title/' . df_lang_ru_en()
	);}, df_module_json($this, 'options')));}
}