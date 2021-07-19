<?php
namespace DB;

class phpjson
{
    public $set;
    public function __construct($array = 0)
    {
        /* Check Connect Type */
        if (empty($array["dburl"]))
        {
            return 0;
        }
        $this->set["dburl"] = $array["dburl"];
    }
    public function add($array = 0)
    { 
        if (empty($array["data"]) || !is_array($array["data"]))
        {
            return 0;
        } 
        if (file_exists($this->set["dburl"]))
        {
            $this->set["dbcache"] = json_decode(implode(file($this->set["dburl"])) , true);
            
            $cache = array();
            $dbid = 0;
            foreach ($this->set["dbcache"] as $key => $val)
            {
                if (!empty($array["options"]["unique"][0]))
                {
                    if (empty($val[$array["options"]["unique"][1]]))
                    {
                        continue;
                    }
                    $uniquecheck = array_search($val[$array["options"]["unique"][1]], array_column($cache, $array["options"]["unique"][1]));
                    if ($uniquecheck > - 1)
                    {
                        continue;
                    }
                }
                $cache[$dbid] = $val;
                ++$dbid;
            }
            foreach ($array["data"] as $key => $val)
            {
                if (!empty($array["options"]["unique"][0]))
                {
                    if (empty($val[$array["options"]["unique"][1]]))
                    {
                        continue;
                    }
                    $uniquecheck = array_search($val[$array["options"]["unique"][1]], array_column($cache, $array["options"]["unique"][1]));
                    if ($uniquecheck > - 1)
                    {
                        continue;
                    }
                }
                $cache[$dbid] = $val;
                ++$dbid;
            }
            if (!empty($cache) && count($cache) > 0)
            {
                file_put_contents($this->set["dburl"], json_encode($cache));
				return "New data added";
            }else{
				return "Error, this data not added";
			}
        }
        else
        {
            $cache = array();
            $dbid = 0;
            foreach ($array["data"] as $key => $val)
            {
                if (!empty($array["options"]["unique"][0]))
                {
                    if (empty($val[$array["options"]["unique"][1]]))
                    {
                        continue;
                    }
                    $uniquecheck = array_search($val[$array["options"]["unique"][1]], array_column($cache, $array["options"]["unique"][1]));
                    if ($uniquecheck > - 1)
                    { 
                        continue;
                    }
                }
                $cache[$dbid] = $val;
                ++$dbid;
            }
            if (!empty($cache) && count($cache) > 0)
            {
                file_put_contents($this->set["dburl"], json_encode($cache));
                return "New data added";
            }else{
				return "Error, this data not added";
			}
        }
		return 0;
    }
    public function view($array = 0)
    {
        if (file_exists($this->set["dburl"]))
        {
            $this->set["dbcache"] = json_decode(implode(file($this->set["dburl"])) , true);
            $cache = array();
            $dbid = 0;
            if (!isset($array["search"]["page"]) || !isset($array["search"]["page_totalcount"]))
            {
                return 0;
            }
            $minkey = ($array["search"]["page"] * $array["search"]["page_totalcount"]);
            $maxkey = ($minkey + $array["search"]["page_totalcount"]);
            $i = 0;
            foreach ($this->set["dbcache"] as $key => $val)
            {
                if (!empty($array["search"]["query"]) && is_array($array["search"]["query"]))
                {
                    $checkquery = 0;
                    $cont = 0;
                    $val["JSON_KEY"] = $key;
                    foreach ($array["search"]["query"] as $queries)
                    {
                        if ($queries[0] == "*")
                        {
                            $checkquery = "all";
                            break;
                        }
                        if (stristr($val[$queries[1]], $queries[0]))
                        {
                            ++$checkquery;
                        }
                    }
                    if ($array["search"]["querytype"] == "and")
                    {
                        if (!empty($array["remove"]))
                        {
                            if (count($array["search"]["query"]) === $checkquery)
                            {
                                $cont = 1;
                            }
                        }
                        else
                        {
                            if (count($array["search"]["query"]) !== $checkquery)
                            {
                                $cont = 1;
                            }
                        }
                    }
                    elseif ($array["search"]["querytype"] == "or")
                    {
                        if (!empty($array["remove"]))
                        {
                            if ($checkquery > 0)
                            {
                                $cont = 1;
                            }
                        }
                        else
                        {
                            if ($checkquery < 1)
                            {
                                $cont = 1;
                            }
                        }
                    }
                    if (!empty($checkquery) && $checkquery == "all")
                    {
                        $cont = 0;
                    }
                    if (!empty($cont))
                    {
                        continue;
                    }
                }
                $ckey = $dbid;
                if ($ckey >= $minkey && $ckey < $maxkey)
                {
                    $cache[$i] = $val;
                    ++$i;
                }
                ++$dbid;
            } 
            return $cache;
        }
    }
    public function del($array = 0)
    {
        if (file_exists($this->set["dburl"]))
        {
            $redata = $this->view($array);
            file_put_contents($this->set["dburl"], json_encode($redata));
			return array("Deleted");
        }
    }
}