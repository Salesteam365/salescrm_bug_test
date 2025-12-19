<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category    PHPExcel
 * @package        PHPExcel_Reader_Excel2007
 * @copyright    Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license        http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version        ##VERSION##, ##DATE##
 */

/**
 * PHPExcel_Reader_Excel2007_Chart
 *
 * @category    PHPExcel
 * @package        PHPExcel_Reader_Excel2007
 * @copyright    Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Reader_Excel2007_Chart
{
    /**
    * Retrieve an attribute value from a SimpleXMLElement and cast it to the requested format.
    * @example
    * $component = new SimpleXMLElement('<element idx="3" value="42.5" active="true"/>');
    * $int = self::getAttribute($component, 'idx', 'integer');
    * echo $int; // 3
    * $str = self::getAttribute($component, 'value', 'string');
    * echo $str; // 42.5
    * $bool = self::getAttribute($component, 'active', 'boolean');
    * var_export($bool); // true
    * @param {SimpleXMLElement} {$component} - Component SimpleXMLElement that contains attributes.
    * @param {string} {$name} - Name of the attribute to retrieve.
    * @param {string} {$format} - Desired return format: 'string', 'integer', 'boolean', or other for float.
    * @returns {string|integer|boolean|float|null} Return value cast to the requested format, or null if attribute is not present.
    */
    private static function getAttribute($component, $name, $format)
    {
        $attributes = $component->attributes();
        if (isset($attributes[$name])) {
            if ($format == 'string') {
                return (string) $attributes[$name];
            } elseif ($format == 'integer') {
                return (integer) $attributes[$name];
            } elseif ($format == 'boolean') {
                return (boolean) ($attributes[$name] === '0' || $attributes[$name] !== 'true') ? false : true;
            } else {
                return (float) $attributes[$name];
            }
        }
        return null;
    }


    private static function readColor($color, $background = false)
    {
        if (isset($color["rgb"])) {
            return (string)$color["rgb"];
        } elseif (isset($color["indexed"])) {
            return PHPExcel_Style_Color::indexedColor($color["indexed"]-7, $background)->getARGB();
        }
    }

    /**
    * Parse chart XML elements and construct a PHPExcel_Chart object.
    * @example
    * $chartXml = simplexml_load_string($chartXmlString); // SimpleXMLElement representing the <c:chart> element
    * $result = PHPExcel_Reader_Excel2007_Chart::readChart($chartXml, 'Sales Chart 2019');
    * print_r($result); // outputs a PHPExcel_Chart object with title, legend, plotArea, axes, etc.
    * @param SimpleXMLElement $chartElements - SimpleXMLElement containing the chart XML elements to parse.
    * @param string $chartName - Name to assign to the resulting chart (e.g. 'Sales Chart 2019').
    * @returns PHPExcel_Chart Returns a PHPExcel_Chart object built from the provided XML chart elements.
    */
    public static function readChart($chartElements, $chartName)
    {
        $namespacesChartMeta = $chartElements->getNamespaces(true);
        $chartElementsC = $chartElements->children($namespacesChartMeta['c']);

        $XaxisLabel = $YaxisLabel = $legend = $title = null;
        $dispBlanksAs = $plotVisOnly = null;

        foreach ($chartElementsC as $chartElementKey => $chartElement) {
            switch ($chartElementKey) {
                case "chart":
                    foreach ($chartElement as $chartDetailsKey => $chartDetails) {
                        $chartDetailsC = $chartDetails->children($namespacesChartMeta['c']);
                        switch ($chartDetailsKey) {
                            case "plotArea":
                                $plotAreaLayout = $XaxisLable = $YaxisLable = null;
                                $plotSeries = $plotAttributes = array();
                                foreach ($chartDetails as $chartDetailKey => $chartDetail) {
                                    switch ($chartDetailKey) {
                                        case "layout":
                                            $plotAreaLayout = self::chartLayoutDetails($chartDetail, $namespacesChartMeta, 'plotArea');
                                            break;
                                        case "catAx":
                                            if (isset($chartDetail->title)) {
                                                $XaxisLabel = self::chartTitle($chartDetail->title->children($namespacesChartMeta['c']), $namespacesChartMeta, 'cat');
                                            }
                                            break;
                                        case "dateAx":
                                            if (isset($chartDetail->title)) {
                                                $XaxisLabel = self::chartTitle($chartDetail->title->children($namespacesChartMeta['c']), $namespacesChartMeta, 'cat');
                                            }
                                            break;
                                        case "valAx":
                                            if (isset($chartDetail->title)) {
                                                $YaxisLabel = self::chartTitle($chartDetail->title->children($namespacesChartMeta['c']), $namespacesChartMeta, 'cat');
                                            }
                                            break;
                                        case "barChart":
                                        case "bar3DChart":
                                            $barDirection = self::getAttribute($chartDetail->barDir, 'val', 'string');
                                            $plotSer = self::chartDataSeries($chartDetail, $namespacesChartMeta, $chartDetailKey);
                                            $plotSer->setPlotDirection($barDirection);
                                            $plotSeries[] = $plotSer;
                                            $plotAttributes = self::readChartAttributes($chartDetail);
                                            break;
                                        case "lineChart":
                                        case "line3DChart":
                                            $plotSeries[] = self::chartDataSeries($chartDetail, $namespacesChartMeta, $chartDetailKey);
                                            $plotAttributes = self::readChartAttributes($chartDetail);
                                            break;
                                        case "areaChart":
                                        case "area3DChart":
                                            $plotSeries[] = self::chartDataSeries($chartDetail, $namespacesChartMeta, $chartDetailKey);
                                            $plotAttributes = self::readChartAttributes($chartDetail);
                                            break;
                                        case "doughnutChart":
                                        case "pieChart":
                                        case "pie3DChart":
                                            $explosion = isset($chartDetail->ser->explosion);
                                            $plotSer = self::chartDataSeries($chartDetail, $namespacesChartMeta, $chartDetailKey);
                                            $plotSer->setPlotStyle($explosion);
                                            $plotSeries[] = $plotSer;
                                            $plotAttributes = self::readChartAttributes($chartDetail);
                                            break;
                                        case "scatterChart":
                                            $scatterStyle = self::getAttribute($chartDetail->scatterStyle, 'val', 'string');
                                            $plotSer = self::chartDataSeries($chartDetail, $namespacesChartMeta, $chartDetailKey);
                                            $plotSer->setPlotStyle($scatterStyle);
                                            $plotSeries[] = $plotSer;
                                            $plotAttributes = self::readChartAttributes($chartDetail);
                                            break;
                                        case "bubbleChart":
                                            $bubbleScale = self::getAttribute($chartDetail->bubbleScale, 'val', 'integer');
                                            $plotSer = self::chartDataSeries($chartDetail, $namespacesChartMeta, $chartDetailKey);
                                            $plotSer->setPlotStyle($bubbleScale);
                                            $plotSeries[] = $plotSer;
                                            $plotAttributes = self::readChartAttributes($chartDetail);
                                            break;
                                        case "radarChart":
                                            $radarStyle = self::getAttribute($chartDetail->radarStyle, 'val', 'string');
                                            $plotSer = self::chartDataSeries($chartDetail, $namespacesChartMeta, $chartDetailKey);
                                            $plotSer->setPlotStyle($radarStyle);
                                            $plotSeries[] = $plotSer;
                                            $plotAttributes = self::readChartAttributes($chartDetail);
                                            break;
                                        case "surfaceChart":
                                        case "surface3DChart":
                                            $wireFrame = self::getAttribute($chartDetail->wireframe, 'val', 'boolean');
                                            $plotSer = self::chartDataSeries($chartDetail, $namespacesChartMeta, $chartDetailKey);
                                            $plotSer->setPlotStyle($wireFrame);
                                            $plotSeries[] = $plotSer;
                                            $plotAttributes = self::readChartAttributes($chartDetail);
                                            break;
                                        case "stockChart":
                                            $plotSeries[] = self::chartDataSeries($chartDetail, $namespacesChartMeta, $chartDetailKey);
                                            $plotAttributes = self::readChartAttributes($plotAreaLayout);
                                            break;
                                    }
                                }
                                if ($plotAreaLayout == null) {
                                    $plotAreaLayout = new PHPExcel_Chart_Layout();
                                }
                                $plotArea = new PHPExcel_Chart_PlotArea($plotAreaLayout, $plotSeries);
                                self::setChartAttributes($plotAreaLayout, $plotAttributes);
                                break;
                            case "plotVisOnly":
                                $plotVisOnly = self::getAttribute($chartDetails, 'val', 'string');
                                break;
                            case "dispBlanksAs":
                                $dispBlanksAs = self::getAttribute($chartDetails, 'val', 'string');
                                break;
                            case "title":
                                $title = self::chartTitle($chartDetails, $namespacesChartMeta, 'title');
                                break;
                            case "legend":
                                $legendPos = 'r';
                                $legendLayout = null;
                                $legendOverlay = false;
                                foreach ($chartDetails as $chartDetailKey => $chartDetail) {
                                    switch ($chartDetailKey) {
                                        case "legendPos":
                                            $legendPos = self::getAttribute($chartDetail, 'val', 'string');
                                            break;
                                        case "overlay":
                                            $legendOverlay = self::getAttribute($chartDetail, 'val', 'boolean');
                                            break;
                                        case "layout":
                                            $legendLayout = self::chartLayoutDetails($chartDetail, $namespacesChartMeta, 'legend');
                                            break;
                                    }
                                }
                                $legend = new PHPExcel_Chart_Legend($legendPos, $legendLayout, $legendOverlay);
                                break;
                        }
                    }
            }
        }
        $chart = new PHPExcel_Chart($chartName, $title, $legend, $plotArea, $plotVisOnly, $dispBlanksAs, $XaxisLabel, $YaxisLabel);

        return $chart;
    }

    /**
    * Create a PHPExcel_Chart_Title from chart title XML details.
    * @example
    * $titleXml = $chartXml->title; // SimpleXMLElement for <c:title>
    * $namespacesChartMeta = ['a' => 'http://schemas.openxmlformats.org/drawingml/2006/main', 'c' => 'http://schemas.openxmlformats.org/drawingml/2006/chart'];
    * $type = 'line';
    * $title = self::chartTitle($titleXml, $namespacesChartMeta, $type);
    * var_dump($title); // outputs PHPExcel_Chart_Title object with caption and layout
    * @param SimpleXMLElement|array $titleDetails - Chart title XML node(s) (rich text and/or layout) to be parsed.
    * @param array $namespacesChartMeta - Namespace map used when accessing XML children (e.g. ['a' => 'http://schemas.openxmlformats.org/drawingml/2006/main']).
    * @param string $type - Chart type identifier (e.g. 'line', 'bar'); not used directly by this method.
    * @returns PHPExcel_Chart_Title The parsed chart title object containing caption (array of text runs) and optional layout.
    */
    private static function chartTitle($titleDetails, $namespacesChartMeta, $type)
    {
        $caption = array();
        $titleLayout = null;
        foreach ($titleDetails as $titleDetailKey => $chartDetail) {
            switch ($titleDetailKey) {
                case "tx":
                    $titleDetails = $chartDetail->rich->children($namespacesChartMeta['a']);
                    foreach ($titleDetails as $titleKey => $titleDetail) {
                        switch ($titleKey) {
                            case "p":
                                $titleDetailPart = $titleDetail->children($namespacesChartMeta['a']);
                                $caption[] = self::parseRichText($titleDetailPart);
                        }
                    }
                    break;
                case "layout":
                    $titleLayout = self::chartLayoutDetails($chartDetail, $namespacesChartMeta);
                    break;
            }
        }

        return new PHPExcel_Chart_Title($caption, $titleLayout);
    }

    /**
     * Parse the chart manualLayout XML element and return a PHPExcel_Chart_Layout instance, or null if no manualLayout is present.
     * @example
     * $chartDetail = simplexml_load_string(
     *     '<c:chart xmlns:c="http://schemas.openxmlformats.org/drawingml/2006/chart">
     *         <c:manualLayout>
     *             <c:x val="0.1"/>
     *             <c:y val="0.2"/>
     *         </c:manualLayout>
     *     </c:chart>'
     * );
     * $namespacesChartMeta = array('c' => 'http://schemas.openxmlformats.org/drawingml/2006/chart');
     * $result = self::chartLayoutDetails($chartDetail, $namespacesChartMeta);
     * // $result is a PHPExcel_Chart_Layout or null; for example var_export($result->getLayout()) might output:
     * // array('x' => '0.1', 'y' => '0.2')
     * @param SimpleXMLElement $chartDetail - SimpleXML node representing the chart; expected to possibly contain a c:manualLayout child.
     * @param array $namespacesChartMeta - Associative array of namespace prefixes to URIs (expects key 'c' for the chart namespace).
     * @returns PHPExcel_Chart_Layout|null Return a PHPExcel_Chart_Layout constructed from manualLayout attribute values, or null if manualLayout is absent or empty.
     */
    private static function chartLayoutDetails($chartDetail, $namespacesChartMeta)
    {
        if (!isset($chartDetail->manualLayout)) {
            return null;
        }
        $details = $chartDetail->manualLayout->children($namespacesChartMeta['c']);
        if (is_null($details)) {
            return null;
        }
        $layout = array();
        foreach ($details as $detailKey => $detail) {
//            echo $detailKey, ' => ',self::getAttribute($detail, 'val', 'string'),PHP_EOL;
            $layout[$detailKey] = self::getAttribute($detail, 'val', 'string');
        }
        return new PHPExcel_Chart_Layout($layout);
    }

    /**
    * Parse chart XML details and return a PHPExcel_Chart_DataSeries populated with series labels, categories, values, order and styling.
    * @example
    * $chartDetail = simplexml_load_string($chartXml); // SimpleXMLElement representing chart XML
    * $namespacesChartMeta = ['c' => 'http://schemas.openxmlformats.org/drawingml/2006/chart'];
    * $result = PHPExcel_Reader_Excel2007_Chart::chartDataSeries($chartDetail, $namespacesChartMeta, PHPExcel_Chart_DataSeries::TYPE_LINECHART);
    * echo get_class($result); // PHPExcel_Chart_DataSeries
    * @param SimpleXMLElement $chartDetail - SimpleXMLElement for the chart detail node (series, grouping, etc.).
    * @param array $namespacesChartMeta - Namespace map used when parsing chart XML (e.g. ['c' => 'http://schemas.openxmlformats.org/drawingml/2006/chart']).
    * @param int|string $plotType - Plot type constant for PHPExcel_Chart_DataSeries (e.g. PHPExcel_Chart_DataSeries::TYPE_LINECHART).
    * @returns PHPExcel_Chart_DataSeries Return a PHPExcel_Chart_DataSeries instance representing the parsed data series.
    */
    private static function chartDataSeries($chartDetail, $namespacesChartMeta, $plotType)
    {
        $multiSeriesType = null;
        $smoothLine = false;
        $seriesLabel = $seriesCategory = $seriesValues = $plotOrder = array();

        $seriesDetailSet = $chartDetail->children($namespacesChartMeta['c']);
        foreach ($seriesDetailSet as $seriesDetailKey => $seriesDetails) {
            switch ($seriesDetailKey) {
                case "grouping":
                    $multiSeriesType = self::getAttribute($chartDetail->grouping, 'val', 'string');
                    break;
                case "ser":
                    $marker = null;
                    foreach ($seriesDetails as $seriesKey => $seriesDetail) {
                        switch ($seriesKey) {
                            case "idx":
                                $seriesIndex = self::getAttribute($seriesDetail, 'val', 'integer');
                                break;
                            case "order":
                                $seriesOrder = self::getAttribute($seriesDetail, 'val', 'integer');
                                $plotOrder[$seriesIndex] = $seriesOrder;
                                break;
                            case "tx":
                                $seriesLabel[$seriesIndex] = self::chartDataSeriesValueSet($seriesDetail, $namespacesChartMeta);
                                break;
                            case "marker":
                                $marker = self::getAttribute($seriesDetail->symbol, 'val', 'string');
                                break;
                            case "smooth":
                                $smoothLine = self::getAttribute($seriesDetail, 'val', 'boolean');
                                break;
                            case "cat":
                                $seriesCategory[$seriesIndex] = self::chartDataSeriesValueSet($seriesDetail, $namespacesChartMeta);
                                break;
                            case "val":
                                $seriesValues[$seriesIndex] = self::chartDataSeriesValueSet($seriesDetail, $namespacesChartMeta, $marker);
                                break;
                            case "xVal":
                                $seriesCategory[$seriesIndex] = self::chartDataSeriesValueSet($seriesDetail, $namespacesChartMeta, $marker);
                                break;
                            case "yVal":
                                $seriesValues[$seriesIndex] = self::chartDataSeriesValueSet($seriesDetail, $namespacesChartMeta, $marker);
                                break;
                        }
                    }
            }
        }
        return new PHPExcel_Chart_DataSeries($plotType, $multiSeriesType, $plotOrder, $seriesLabel, $seriesCategory, $seriesValues, $smoothLine);
    }


    /**
    * Build and return a PHPExcel_Chart_DataSeriesValues instance for the given series XML node (handles strRef, numRef, multiLvlStrRef and multiLvlNumRef), or null if no recognized reference is found.
    * @example
    * $seriesDetail = simplexml_load_string('<ser><numRef><f>Sheet1!$B$2:$B$6</f><numCache><formatCode>General</formatCode><ptCount val="5"/><pt idx="0"><v>1</v></pt></numCache></numRef></ser>');
    * $namespaces = ['c' => 'http://schemas.openxmlformats.org/drawingml/2006/chart'];
    * $result = PHPExcel_Reader_Excel2007_Chart::chartDataSeriesValueSet($seriesDetail, $namespaces, null, false);
    * var_dump($result); // instance of PHPExcel_Chart_DataSeriesValues or NULL
    * @param {SimpleXMLElement} $seriesDetail - SimpleXML node describing the series (may contain strRef, numRef, multiLvlStrRef or multiLvlNumRef).
    * @param {array} $namespacesChartMeta - Chart namespace metadata array (e.g. ['c' => 'http://schemas.openxmlformats.org/drawingml/2006/chart']).
    * @param {mixed|null} $marker - Optional marker information to pass to the DataSeriesValues constructor (default null).
    * @param {bool} $smoothLine - Whether the series line should be smoothed (default false).
    * @returns {PHPExcel_Chart_DataSeriesValues|null} Return a PHPExcel_Chart_DataSeriesValues object when a series reference is found, otherwise null.
    */
    private static function chartDataSeriesValueSet($seriesDetail, $namespacesChartMeta, $marker = null, $smoothLine = false)
    {
        if (isset($seriesDetail->strRef)) {
            $seriesSource = (string) $seriesDetail->strRef->f;
            $seriesData = self::chartDataSeriesValues($seriesDetail->strRef->strCache->children($namespacesChartMeta['c']), 's');

            return new PHPExcel_Chart_DataSeriesValues('String', $seriesSource, $seriesData['formatCode'], $seriesData['pointCount'], $seriesData['dataValues'], $marker, $smoothLine);
        } elseif (isset($seriesDetail->numRef)) {
            $seriesSource = (string) $seriesDetail->numRef->f;
            $seriesData = self::chartDataSeriesValues($seriesDetail->numRef->numCache->children($namespacesChartMeta['c']));

            return new PHPExcel_Chart_DataSeriesValues('Number', $seriesSource, $seriesData['formatCode'], $seriesData['pointCount'], $seriesData['dataValues'], $marker, $smoothLine);
        } elseif (isset($seriesDetail->multiLvlStrRef)) {
            $seriesSource = (string) $seriesDetail->multiLvlStrRef->f;
            $seriesData = self::chartDataSeriesValuesMultiLevel($seriesDetail->multiLvlStrRef->multiLvlStrCache->children($namespacesChartMeta['c']), 's');
            $seriesData['pointCount'] = count($seriesData['dataValues']);

            return new PHPExcel_Chart_DataSeriesValues('String', $seriesSource, $seriesData['formatCode'], $seriesData['pointCount'], $seriesData['dataValues'], $marker, $smoothLine);
        } elseif (isset($seriesDetail->multiLvlNumRef)) {
            $seriesSource = (string) $seriesDetail->multiLvlNumRef->f;
            $seriesData = self::chartDataSeriesValuesMultiLevel($seriesDetail->multiLvlNumRef->multiLvlNumCache->children($namespacesChartMeta['c']), 's');
            $seriesData['pointCount'] = count($seriesData['dataValues']);

            return new PHPExcel_Chart_DataSeriesValues('String', $seriesSource, $seriesData['formatCode'], $seriesData['pointCount'], $seriesData['dataValues'], $marker, $smoothLine);
        }
        return null;
    }


    /**
    * Parse a chart series value set from Excel2007 chart XML and return its format code, point count and data values.
    * @example
    * $result = PHPExcel_Reader_Excel2007_Chart::chartDataSeriesValues($seriesValueSet, 'n');
    * print_r($result); // Array ( 'formatCode' => 'General', 'pointCount' => 3, 'dataValues' => Array ( [0] => 10.0 [1] => 20.0 [2] => 30.0 ) )
    * @param array|\SimpleXMLElement $seriesValueSet - Series value set nodes from chart XML (contains ptCount, formatCode and pt elements).
    * @param string $dataType - Data type flag: 'n' for numeric values (default) or 's' for string values.
    * @returns array Returns an associative array with keys 'formatCode' (string), 'pointCount' (int) and 'dataValues' (array of values).
    */
    private static function chartDataSeriesValues($seriesValueSet, $dataType = 'n')
    {
        $seriesVal = array();
        $formatCode = '';
        $pointCount = 0;

        foreach ($seriesValueSet as $seriesValueIdx => $seriesValue) {
            switch ($seriesValueIdx) {
                case 'ptCount':
                    $pointCount = self::getAttribute($seriesValue, 'val', 'integer');
                    break;
                case 'formatCode':
                    $formatCode = (string) $seriesValue;
                    break;
                case 'pt':
                    $pointVal = self::getAttribute($seriesValue, 'idx', 'integer');
                    if ($dataType == 's') {
                        $seriesVal[$pointVal] = (string) $seriesValue->v;
                    } else {
                        $seriesVal[$pointVal] = (float) $seriesValue->v;
                    }
                    break;
            }
        }

        return array(
            'formatCode'    => $formatCode,
            'pointCount'    => $pointCount,
            'dataValues'    => $seriesVal
        );
    }

    /**
    * Parse a multi-level series value set from Excel chart XML and return its format code, point count and assembled data values.
    * @example
    * $sampleXml  = '<root><lvl><pt idx="0"><v>10</v></pt><pt idx="1"><v>20</v></pt><pt idx="2"><v>30</v></pt><ptCount val="3"/><formatCode>General</formatCode></lvl></root>';
    * $seriesValueSet = simplexml_load_string($sampleXml);
    * $result = chartDataSeriesValuesMultiLevel($seriesValueSet, 'n');
    * print_r($result); // Array ( [formatCode] => General [pointCount] => 3 [dataValues] => Array ( [0] => Array ( [0] => 10 ) [1] => Array ( [0] => 20 ) [2] => Array ( [0] => 30 ) ) )
    * @param {{SimpleXMLElement}} {{seriesValueSet}} - SimpleXMLElement representing the multi-level <lvl> series value set from the chart XML.
    * @param {{string}} {{dataType}} - Data type flag: 'n' for numeric (default) or 's' for string values.
    * @returns {{array}} Return associative array with keys 'formatCode' (string), 'pointCount' (int) and 'dataValues' (array).
    */
    private static function chartDataSeriesValuesMultiLevel($seriesValueSet, $dataType = 'n')
    {
        $seriesVal = array();
        $formatCode = '';
        $pointCount = 0;

        foreach ($seriesValueSet->lvl as $seriesLevelIdx => $seriesLevel) {
            foreach ($seriesLevel as $seriesValueIdx => $seriesValue) {
                switch ($seriesValueIdx) {
                    case 'ptCount':
                        $pointCount = self::getAttribute($seriesValue, 'val', 'integer');
                        break;
                    case 'formatCode':
                        $formatCode = (string) $seriesValue;
                        break;
                    case 'pt':
                        $pointVal = self::getAttribute($seriesValue, 'idx', 'integer');
                        if ($dataType == 's') {
                            $seriesVal[$pointVal][] = (string) $seriesValue->v;
                        } else {
                            $seriesVal[$pointVal][] = (float) $seriesValue->v;
                        }
                        break;
                }
            }
        }

        return array(
            'formatCode'    => $formatCode,
            'pointCount'    => $pointCount,
            'dataValues'    => $seriesVal
        );
    }

    /**
    * Parse a chart title's rich text runs and convert them into a PHPExcel_RichText object.
    * @example
    * $xml = new SimpleXMLElement('<title><tx><rich><a:p><a:r><a:t>Hello</a:t></a:r></a:p></rich></tx></title>');
    * $titleDetailPart = $xml->tx->rich->p->r; // SimpleXMLElement list of <a:r> runs
    * $result = PHPExcel_Reader_Excel2007_Chart::parseRichText($titleDetailPart);
    * echo $result->getPlainText(); // render "Hello"
    * @param {SimpleXMLElement[]|array|null} $titleDetailPart - Array or SimpleXMLElement list of rich text run elements; each element may contain 't' (text) and 'rPr' (run properties).
    * @returns {PHPExcel_RichText} PHPExcel_RichText object containing the parsed text runs with applied font formatting (name, size, color, bold, italic, superscript/subscript, underline, strikethrough).
    */
    private static function parseRichText($titleDetailPart = null)
    {
        $value = new PHPExcel_RichText();

        foreach ($titleDetailPart as $titleDetailElementKey => $titleDetailElement) {
            if (isset($titleDetailElement->t)) {
                $objText = $value->createTextRun((string) $titleDetailElement->t);
            }
            if (isset($titleDetailElement->rPr)) {
                if (isset($titleDetailElement->rPr->rFont["val"])) {
                    $objText->getFont()->setName((string) $titleDetailElement->rPr->rFont["val"]);
                }

                $fontSize = (self::getAttribute($titleDetailElement->rPr, 'sz', 'integer'));
                if (!is_null($fontSize)) {
                    $objText->getFont()->setSize(floor($fontSize / 100));
                }

                $fontColor = (self::getAttribute($titleDetailElement->rPr, 'color', 'string'));
                if (!is_null($fontColor)) {
                    $objText->getFont()->setColor(new PHPExcel_Style_Color(self::readColor($fontColor)));
                }

                $bold = self::getAttribute($titleDetailElement->rPr, 'b', 'boolean');
                if (!is_null($bold)) {
                    $objText->getFont()->setBold($bold);
                }

                $italic = self::getAttribute($titleDetailElement->rPr, 'i', 'boolean');
                if (!is_null($italic)) {
                    $objText->getFont()->setItalic($italic);
                }

                $baseline = self::getAttribute($titleDetailElement->rPr, 'baseline', 'integer');
                if (!is_null($baseline)) {
                    if ($baseline > 0) {
                        $objText->getFont()->setSuperScript(true);
                    } elseif ($baseline < 0) {
                        $objText->getFont()->setSubScript(true);
                    }
                }

                $underscore = (self::getAttribute($titleDetailElement->rPr, 'u', 'string'));
                if (!is_null($underscore)) {
                    if ($underscore == 'sng') {
                        $objText->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
                    } elseif ($underscore == 'dbl') {
                        $objText->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_DOUBLE);
                    } else {
                        $objText->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_NONE);
                    }
                }

                $strikethrough = (self::getAttribute($titleDetailElement->rPr, 's', 'string'));
                if (!is_null($strikethrough)) {
                    if ($strikethrough == 'noStrike') {
                        $objText->getFont()->setStrikethrough(false);
                    } else {
                        $objText->getFont()->setStrikethrough(true);
                    }
                }
            }
        }

        return $value;
    }

    /****
    * Extracts data label display attributes from a chart detail object and returns them as an associative array.
    * @example
    * $chartDetail = simplexml_load_string('<chart><dLbls><showLegendKey val="1"/><showVal val="0"/><showCatName val="1"/></dLbls></chart>');
    * $result = PHPExcel_Reader_Excel2007_Chart::readChartAttributes($chartDetail);
    * echo var_export($result, true); // array ('showLegendKey' => '1', 'showVal' => '0', 'showCatName' => '1')
    * @param {SimpleXMLElement|object} $chartDetail - SimpleXML or object representing the chart detail node (may contain dLbls children).
    * @returns {array} Associative array of plot attributes (keys like showLegendKey, showVal, showCatName, showSerName, showPercent, showBubbleSize, showLeaderLines) with string values.
    */
    private static function readChartAttributes($chartDetail)
    {
        $plotAttributes = array();
        if (isset($chartDetail->dLbls)) {
            if (isset($chartDetail->dLbls->howLegendKey)) {
                $plotAttributes['showLegendKey'] = self::getAttribute($chartDetail->dLbls->showLegendKey, 'val', 'string');
            }
            if (isset($chartDetail->dLbls->showVal)) {
                $plotAttributes['showVal'] = self::getAttribute($chartDetail->dLbls->showVal, 'val', 'string');
            }
            if (isset($chartDetail->dLbls->showCatName)) {
                $plotAttributes['showCatName'] = self::getAttribute($chartDetail->dLbls->showCatName, 'val', 'string');
            }
            if (isset($chartDetail->dLbls->showSerName)) {
                $plotAttributes['showSerName'] = self::getAttribute($chartDetail->dLbls->showSerName, 'val', 'string');
            }
            if (isset($chartDetail->dLbls->showPercent)) {
                $plotAttributes['showPercent'] = self::getAttribute($chartDetail->dLbls->showPercent, 'val', 'string');
            }
            if (isset($chartDetail->dLbls->showBubbleSize)) {
                $plotAttributes['showBubbleSize'] = self::getAttribute($chartDetail->dLbls->showBubbleSize, 'val', 'string');
            }
            if (isset($chartDetail->dLbls->showLeaderLines)) {
                $plotAttributes['showLeaderLines'] = self::getAttribute($chartDetail->dLbls->showLeaderLines, 'val', 'string');
            }
        }

        return $plotAttributes;
    }

    /**
    * Apply boolean display attributes to a chart plot area from an associative array.
    * @example
    * $plotArea = new PHPExcel_Chart_PlotArea(); // or retrieve existing plot area instance
    * $attributes = [
    *     'showLegendKey'   => true,
    *     'showVal'         => false,
    *     'showCatName'     => true,
    *     'showSerName'     => false,
    *     'showPercent'     => false,
    *     'showBubbleSize'  => true,
    *     'showLeaderLines' => true,
    * ];
    * // Called from within the defining class (method is private static)
    * self::setChartAttributes($plotArea, $attributes);
    * @param object $plotArea - The plot area object to modify (expects setters like setShowVal(), setShowCatName(), etc.).
    * @param array $plotAttributes - Associative array of attribute names to boolean values (e.g. ['showVal' => true]).
    * @returns void Void; modifies the provided plot area instance in place.
    */
    private static function setChartAttributes($plotArea, $plotAttributes)
    {
        foreach ($plotAttributes as $plotAttributeKey => $plotAttributeValue) {
            switch ($plotAttributeKey) {
                case 'showLegendKey':
                    $plotArea->setShowLegendKey($plotAttributeValue);
                    break;
                case 'showVal':
                    $plotArea->setShowVal($plotAttributeValue);
                    break;
                case 'showCatName':
                    $plotArea->setShowCatName($plotAttributeValue);
                    break;
                case 'showSerName':
                    $plotArea->setShowSerName($plotAttributeValue);
                    break;
                case 'showPercent':
                    $plotArea->setShowPercent($plotAttributeValue);
                    break;
                case 'showBubbleSize':
                    $plotArea->setShowBubbleSize($plotAttributeValue);
                    break;
                case 'showLeaderLines':
                    $plotArea->setShowLeaderLines($plotAttributeValue);
                    break;
            }
        }
    }
}
