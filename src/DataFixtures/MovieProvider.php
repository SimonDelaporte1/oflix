<?php

namespace App\DataFixtures;
class MovieProvider extends \Faker\Provider\Base
{
    public function getMovie($id)
    {
        $movie_array = array(
            array('summary'=> $this->generator->paragraph(2),'synopsis'=> $this->generator->realText(500), 'type'=>'Film','title'=>'Hulk','release_date'=> $this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(1,1,5)),
            array('summary'=> $this->generator->paragraph(2),'synopsis'=> $this->generator->realText(500), 'type'=>'Série','title'=>'Breaking bad','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(1,1,5)),
            array('summary'=> $this->generator->paragraph(2),'synopsis'=> $this->generator->realText(500), 'type'=>'Film','title'=>'Iron man','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(1,1,5)),
            array('summary'=> $this->generator->paragraph(2),'synopsis'=> $this->generator->realText(500), 'type'=>'Film','title'=>'Jack Reacher','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(1,1,5)),
            array('summary'=> $this->generator->paragraph(2),'synopsis'=> $this->generator->realText(500), 'type'=>'Film','title'=>'Suicide squad','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(1,1,5)),
            array('summary'=> $this->generator->paragraph(2),'synopsis'=> $this->generator->realText(500), 'type'=>'Film','title'=>'Thor','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(1,1,5)),
            array('summary'=> $this->generator->paragraph(2),'synopsis'=> $this->generator->realText(500), 'type'=>'Série','title'=>'Casa de papel','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(1,1,5)),
            array('summary'=> $this->generator->paragraph(2),'synopsis'=> $this->generator->realText(500), 'type'=>'Série','title'=>'Narcos','release_date'=>$this->generator->dateTime(),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/id/'.$this->unique()->randomNumber(2).'/200/300','rating'=>$this->randomFloat(1,1,5)),
        );
        return $movie_array[$id];
    }       
}