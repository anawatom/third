import { NgModule, ErrorHandler } from '@angular/core';
import { IonicApp, IonicModule, IonicErrorHandler } from 'ionic-angular';
import { MyApp } from './app.component';

// Custom components
import { SideMenuContentComponent } from '../components/side-menu/side-menu';

// Pages
import { MainPage } from '../pages/main-page/main-page';
import { DetailPage } from '../pages/detail-page/detail-page';

@NgModule({
  declarations: [
    MyApp,
    SideMenuContentComponent,
    MainPage,
    DetailPage
  ],
  imports: [
    IonicModule.forRoot(MyApp)
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    MainPage,
    DetailPage
  ],
  providers: [{provide: ErrorHandler, useClass: IonicErrorHandler}]
})
export class AppModule {}
