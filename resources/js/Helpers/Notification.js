/**
 * Created by mukar on 10/1/2021.
 */

class Notification{

   success(){
       new Noty({

           type: 'success',
           text: 'Successfully done...',
           layout: 'topRight',
           timeout: 2000,
       }).show();
   }

    cart_success(){
        new Noty({

            type: 'success',
            text: 'Successfully Add To Cart',
            layout: 'topRight',
            timeout: 2000,
        }).show();
    }

    cart_deleted(){
        new Noty({

            type: 'success',
            text: 'Successfully Cart Deleted',
            layout: 'topRight',
            timeout: 2000,
        }).show();
    }

    alert(){
        new Noty({

            type: 'alert',
            text: 'Are you sure ???',
            layout: 'topRight',
            timeout: 2000,
        }).show();
    }

    error(){
        new Noty({

            type: 'alert',
            text: 'Something went wrong !',
            layout: 'topRight',
            timeout: 2000,
        }).show();
    }

    warning(){
        new Noty({

            type: 'warning',
            text: 'Oops Wrong !',
            layout: 'topRight',
            timeout: 2000,
        }).show();
    }

    image_validation(){
        new Noty({

            type: 'warning',
            text: 'Upload File less than 1mb',
            layout: 'topRight',
            timeout: 2000,
        }).show();
    }


}
export default Notification = new Notification();
