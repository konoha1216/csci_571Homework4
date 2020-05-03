import { Component, OnInit } from '@angular/core';
import {SearchServiceService} from '../../service/search-service.service'
import { Key } from 'protractor';

@Component({
  selector: 'app-favorites',
  templateUrl: './favorites.component.html',
  styleUrls: ['./favorites.component.css']
})
export class FavoritesComponent implements OnInit {

  public noFavorites=true;
  public parsedLocalStorage=[];
  public favoriteList=[];


  constructor(public sService:SearchServiceService) {
  //   this.sService.favoriteList.subscribe(data=>{
  //     console.log("?????????????favorite listdata",data)
  //     if(data[0]){
  //       console.log('!!!!!!!!!!!favorite List data',data);
  //       this.favoriteList = data;
  //       this.noFavorites = false;
  //     }else{
  //       this.noFavorites = true;
  //     }
  //   })
  if(window.localStorage.length>0){
    this.noFavorites = false;
    
    for (var i = 0; i < window.localStorage.length; i++){
      this.favoriteList[i]=JSON.parse(localStorage.getItem(localStorage.key(i)));
    }
  }
  else{
    this.noFavorites = true;
  }
  console.log('this.favoriteList!!!!!!!!!!!!!!!!!!!hahahahahaha',this.favoriteList);
}

  removeFavorite(id,key){
    this.sService.removeFavorite1(id);
    this.favoriteList.splice(key,1);

  }

  favoriteSearch(myCity, myState){
    this.sService.searchFavorite(myCity, myState);
    
  }

  ngOnInit() {
  }

  getLocalStorageLength(){
    return localStorage.length;
  }
}
