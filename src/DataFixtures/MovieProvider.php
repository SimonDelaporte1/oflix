<?php

namespace Faker\Provider;
class MovieProvider extends \Faker\Provider\Base
{
    public function getMovie()
    {
        $movie_array = array(
            array('summary'=> $this->generator->paragraph(2),'synopsis'=> $this->generator->realText(500), 'type'=>'Film','title'=>'L’Attaque de la Moussaka géante','release_date'=> $this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(1,1,5)),
            array('summary'=> $this->generator->paragraph(2),'synopsis'=> $this->generator->realText(500), 'type'=>'Série','title'=>'Game of throne','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(1,1,5)),
            array('summary'=> $this->generator->paragraph(2),'synopsis'=> $this->generator->realText(500), 'type'=>'Film','title'=>'100 000 dollars au soleil','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(1,1,5)),
            array('summary'=> $this->generator->paragraph(2),'synopsis'=> $this->generator->realText(500), 'type'=>'Film','title'=>'Jack Reacher','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(1,1,5)),
            array('summary'=> $this->generator->paragraph(2),'synopsis'=> $this->generator->realText(500), 'type'=>'Film','title'=>'Suicide squad','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(1,1,5)),
            array('summary'=> $this->generator->paragraph(2),'synopsis'=> $this->generator->realText(500), 'type'=>'Film','title'=>'Un flic','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(1,1,5)),
            array('summary'=> $this->generator->paragraph(2),'synopsis'=> $this->generator->realText(500), 'type'=>'Série','title'=>'La casa de papel','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(1,1,5)),
            array('summary'=> $this->generator->paragraph(2),'synopsis'=> $this->generator->realText(500), 'type'=>'Série','title'=>'Narcos','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(1,1,5)),
        );
        return $movie_array[array_rand($movie_array)];
    }       
}