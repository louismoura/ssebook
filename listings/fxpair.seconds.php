<?php
class FXPair{
  /** The name of the FX pair */
  private $symbol;
  /** The mean bid price */
  private $bid;
  /** The spread. Add to $bid to get "ask".*/
  private $spread;
  /** Accuracy to quote prices to.*/
  private $decimalPlaces;
  /** Number of seconds for one bigger cycle */
  private $longCycle;
  /** Number of seconds for the small cycle */
  private $shortCycle;

  /** Constructor */
  public function __construct($symbol,$b,$s,$d,$c1,$c2){
    $this->symbol = $symbol;
    $this->bid = $b;
    $this->spread = $s;
    $this->decimalPlaces = $d;
    $this->longCycle = $c1;
    $this->shortCycle = $c2;
  }

  /** @param int $t Seconds since 1970 */
  public function generate($t){
  $bid = $this->bid;
  $bid+= $this->spread * 100 *
    sin( (360 / $this->longCycle) * (deg2rad($t % $this->longCycle)) );
  $bid+= $this->spread * 30 *
    sin( (360 / $this->shortCycle) *(deg2rad($t % $this->shortCycle)) );
  $bid += (mt_rand(-1000,1000)/1000.0) * 10 * $this->spread;
  $ask = $bid + $this->spread;

  return array(
    "timestamp"=>gmdate("Y-m-d H:i:s",$t),
    "symbol"=>$this->symbol,
    "bid"=>number_format($bid,$this->decimalPlaces),
    "ask"=>number_format($ask,$this->decimalPlaces),
    );
  }

}
