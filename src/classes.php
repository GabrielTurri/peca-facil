<?php

    class Loja {
        public $nome;
        public $link;
        public $icone;

        public function __construct($nome, $link, $icone){
            $this->nome = $nome;
            $this->link = $link;
            $this->icone = $icone;
        }


    }