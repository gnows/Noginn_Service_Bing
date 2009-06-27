<?php

/**
 * Video source result set
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage Bing
 * @author Tom Graham
 */
class Noginn_Service_Bing_VideoResultSet extends Noginn_Service_Bing_ResultSet
{
    /**
     * The total number of results
     *
     * @var int
     */
    protected $_total = 0;
    
    /**
     * The offset
     *
     * @var int
     */
    protected $_offset = 0;
    
    /**
     * Constructor.
     *
     * @param DOMElement $dom 
     */
    public function __construct(DOMElement $dom)
    {
        $xpath = new DOMXPath($dom->ownerDocument);
        $xpath->registerNamespace('mms', Noginn_Service_Bing::API_NAMESPACE_MULTIMEDIA);
        
        $this->_total = (int) $xpath->query('//mms:Total/text()', $dom)->item(0)->data;
        $this->_offset = (int) $xpath->query('//mms:Offset/text()', $dom)->item(0)->data;
        
        $this->_results = $xpath->query('//mms:VideoResult');
    }
    
    /**
     * Returns the total number of results
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->_total;
    }
    
    /**
     * Returns the offset
     *
     * @return int
     */
    public function getOffset()
    {
        return $this->_offset;
    }
    
    /**
     * Implements SeekableIterator::current().
     *
     * @return  void
     * @throws  Zend_Service_Exception
     */
    public function current()
    {
        return new Noginn_Service_Bing_VideoResult($this->_results->item($this->_currentIndex));
    }
}
