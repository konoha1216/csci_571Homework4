import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule }   from '@angular/forms';
import { HttpClientModule} from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { SearchFormComponent } from './component/search-form/search-form.component';
import { ResultsComponent } from './component/results/results.component';
import { NavsComponent } from './component/navs/navs.component';

import {SearchServiceService} from './service/search-service.service';
import { ShowContentComponent } from './component/show-content/show-content.component';
import { CurrentComponent } from './component/current/current.component';
import { HourlyComponent } from './component/hourly/hourly.component';
import { WeeklyComponent } from './component/weekly/weekly.component';

import { ChartsModule } from 'ng2-charts';

import { Routes, RouterModule } from '@angular/router';
import { FavoritesComponent } from './component/favorites/favorites.component';
const routes: Routes = [
  {path: 'Weekly', component: WeeklyComponent},
  {path: 'Hourly', component: HourlyComponent},
  {path: 'Current', component: CurrentComponent},
  {path:'showContent', component:ShowContentComponent},
  {path:'searchForm', component:AppComponent},
  {path:'Favorites', component:FavoritesComponent}
];

@NgModule({
  declarations: [
    AppComponent,
    SearchFormComponent,
    ResultsComponent,
    NavsComponent,
    ShowContentComponent,
    CurrentComponent,
    HourlyComponent,
    WeeklyComponent,
    FavoritesComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    HttpClientModule,
    RouterModule.forRoot(routes),
    ChartsModule
  ],
  providers: [SearchServiceService],
  bootstrap: [AppComponent]
})
export class AppModule { }
