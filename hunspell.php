<?php

namespace glex;

use glex\hunspellFFI\hunspellFFI;
use glex\hunspellFFI\string_;
use FFI;

class hunspell {

    private $hunspellFFI;
    private $hunhandle;

    public function __construct(string $aff, string $dic, string $pathToSoFile = hunspellFFI::SOFILE) {
        $this->hunspellFFI = new hunspellFFI($pathToSoFile);
        $this->hunhandle = $this->hunspellFFI->Hunspell_create($aff, $dic);
    }

    public function __destruct() {
        $this->hunspellFFI->Hunspell_destroy($this->hunhandle);
    }


    public function spell(string $word) {
        return $this->hunspellFFI->Hunspell_spell($this->hunhandle, $word);
    }

    public function suggest(string $word) {
        return $this->handleList('Hunspell_suggest', [$word]);
    }

    public function analyze(string $word) {
        return $this->handleList('Hunspell_analyze', [$word]);
    }

    public function stem(string $word) {
        return $this->handleList('Hunspell_stem', [$word]);
    }

    public function generate(string $word1, string $word2) {
        return $this->handleList('Hunspell_generate', [$word1, $word2]);
    }

    public function add(string $word) {
        return $this->hunspellFFI->Hunspell_add($this->hunhandle, $word);
    }

    public function remove(string $word) {
        return $this->hunspellFFI->Hunspell_remove($this->hunhandle, $word);
    }

    private function handleList(string $func, array $args) {
        $res1 = new string_($this->hunspellFFI->getFFI()->new('char*'));
        $res2 = $res1->addr();
        $res3 = $res2->addr();

        $size = call_user_func_array(array($this->hunspellFFI, $func), array_merge([$this->hunhandle, $res3], $args));

        $result = [];
        for ($i = 0; $i < $size; $i++) {
            $deref = $res2->deref($i);
            $result[] = $deref->toString();
        }

        $this->hunspellFFI->Hunspell_free_list($this->hunhandle, $res3, $size);

        FFI::free($res3->getData());
        FFI::free($res2->getData());
        FFI::free($res1->getData());

        return $result;
    }

}