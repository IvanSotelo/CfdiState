<?php
/**
 * Copyright: © 2020 IvanSotelo
 * Date: 2020-02-20
 * Time: 17:21
 */
namespace IvanSotelo\CfdiState;

use PhpCfdi\CfdiExpresiones\DiscoverExtractor;

class CFDIState
{
    protected $data;
    protected $type;
    protected $en_data;
    protected $es_data;

    protected $expression;
    protected $service;
    /**
     * CFDI constructor.
     * @param null $xml_path
     */
    public function __construct($xml)
    {
        $this->type = 'cfdi';
        $this->render($xml);
        $document = new \DOMDocument();
        $document->load($xml);

        // creamos el extractor
        $extractor = new DiscoverExtractor();
        $this->expression = $extractor->extract($document);

        //$service = new CFDIService();
    }
    
    /**
     * Convert CFDI to json
     * @return string
     */
    public function toJson($lang = 'es')
    {
        return json_encode($this->{$lang . '_data'}->data);
    }

    /**
     * Render CFDIs
     *
     * @param String $xml
     * @return void
     */
    public function render($xml)
    {
        $xml = simplexml_load_file($xml, 'SimpleXMLElement', 0, $this->type, true);

        $result = [];
        $this->iterator($xml, $result, "//{$this->type}:Comprobante");

        $this->data = collect($result)->first();

        $this->data['cadena_original'] = $this->makeOriginalString($xml);
        $this->en_data = $this->translate($this->data);
        $this->es_data = $this->translate($this->data, 'es');
    }

    protected function makeOriginalString($xml)
    {
        $xsl = new \DOMDocument('1.0', 'UTF-8');
        $xsl->load(__DIR__ . '/resources/xslt/3.3/cadenaoriginal_3_3.xslt');
        $proc = new \XSLTProcessor;
        $proc->importStyleSheet($xsl);
        return $proc->transformToXML($xml);
    }

    protected function translate($data, $lang = 'en')
    {
        if (!is_array($data)) {
            return $data;
        }

        $aux = new CFDINode();
        foreach ($data as $key => $value) {
            if (is_integer($key)) {
                //$aux->items->push($this->translate($value, $lang));
            //$is_collection = true;
                //$aux[$key] = $this->translate($value, $lang);
            } elseif ($lang == 'en') {
                $aux->{trans('ivansotelo::cfdi.' . $key)} = $this->translate($value, $lang);
            } elseif ($lang == 'es') {
                $aux->{$key} = $this->translate($value, $lang);
            }
        }
        return $aux;
    }

    /**
     * Interacts between nodes to convert to array
     * @param $xml
     * @param $parent
     * @param string $path
     */
    protected function iterator($xml, &$parent, $path = '')
    {
        $result = [];
        $name = $xml->getName();

        foreach ($xml->attributes() as $key => $value) {
            $result[$key] = (string)$xml->attributes()->{$key};
        }

        $namespaces = $xml->getNamespaces(true);
        foreach ($namespaces as $pre => $ns) {
            foreach ($xml->children($ns) as $k => $v) {
                $new_path = $path . "//{$pre}:{$k}";
                $this->iterator($v, $result, $new_path);
            }
        }

        $path_parts = explode('//', $path);

        if (ends_with($path, 'Deduccion')) {
            //    dd($path_parts);
        }

        if (
            count($path_parts) >= 1 and
            in_array($path_parts[count($path_parts) - 2], [last($path_parts) . 's', last($path_parts) . 'es'])
            ) {
            $parent[] = $result;
        } else {
            $parent[$name] = $result;
        }
    }

    public function __get($name)
    {
        if (!is_null($this->en_data->{$name})) {
            return $this->en_data->{$name};
        }

        if (!is_null($this->es_data->{$name})) {
            return $this->es_data->{$name};
        }

        if (method_exists($this, 'get' . ucfirst(camel_case($name)))) {
            return $this->{'get' . ucfirst(camel_case($name))}();
        }

        return null;
    }
    
    public function getState()
    {
        return $this->data['Certificado'];
    }

    public function getExpression()
    {
        return  $this->expression;
    }
}