<?php

namespace Faker\Provider;
class MovieProvider extends \Faker\Provider\Base
{
    private $synopsis_array = array('Lorem', 'ipsum', 'dolor', 'sit', 'amet', 'bla', 'bli', 'je', 'mange', 'des', 'légumes', 'avec', 'de', 'la', 'soupe');
    private $summary_array = array('Ceci', 'est', 'une', 'description', 'courte', 'du', 'film', 'que', 'vous', 'allez', 'voir', 'consectetur', 'adipiscing','elit.','Proin','et','aliquet','nibh.','ed','nec','velit','vel','lacus','posuere','dignissim.','Nunc','gravida','auctor','dapibus.','Nulla','faucibus','justo','in','accumsan','laoreet.','Suspendisse','quis','lacinia','tortor.','Cras','auctor','lorem','eget','efficitur','tincidunt.','Vestibulum','ac','eleifend','lectus.','Cras','fringilla','felis','nec','posuere','feugiat.');

    public function getMovie()
    {
        $movie_array = array(
            array('type'=>'Film','title'=>'L’Attaque de la Moussaka géante','release_date'=> $this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(2,1,5)),
            array('type'=>'Série','title'=>'Game of throne','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(2,1,5)),
            array('type'=>'Film','title'=>'100 000 dollars au soleil','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(2,1,5)),
            array('type'=>'Film','title'=>'Jack Reacher','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(2,1,5)),
            array('type'=>'Film','title'=>'Suicide squad','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(2,1,5)),
            array('type'=>'Film','title'=>'Un flic','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(2,1,5)),
            array('type'=>'Série','title'=>'La casa de papel','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(2,1,5)),
            array('type'=>'Série','title'=>'Narco','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(2,1,5)),
        );
        shuffle($this->summary_array);
        shuffle($this->synopsis_array);
        $id = mt_rand(0, count($movie_array)-1);
        $movie_array[$id]['summary'] = implode(' ', $this->summary_array);
        $movie_array[$id]['synopsis'] = implode(' ', $this->synopsis_array);
        return $movie_array[$id];
    }       
}