package com.dite.lalupa;

import android.app.*;
import android.content.*;
import android.os.*;
import android.view.*;
import android.webkit.*;
import android.widget.*;

public class MainActivity extends Activity 
{

    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
		this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.main);

		WebView webView = (WebView) findViewById(R.id.webview);
        webView.getSettings().setLoadsImagesAutomatically(true);

        // Tiga baris di bawah ini agar laman yang dimuat dapat
        // melakukan zoom.
        webView.getSettings().setSupportZoom(true);
        webView.getSettings().setBuiltInZoomControls(true);
        webView.getSettings().setDisplayZoomControls(false);
        // Baris di bawah untuk menambahkan scrollbar di dalam WebView-nya
        webView.setScrollBarStyle(View.SCROLLBARS_INSIDE_OVERLAY);
		// Enable javascript
		webView.getSettings().setJavaScriptEnabled(true);
		webView.getSettings().setDomStorageEnabled(true);
		// Javasript to Java
		//webView.addJavascriptInterface(new JavascriptToJava(this), "Android");
		webView.addJavascriptInterface(new JavascriptToJava1(), "Android");

        webView.setWebViewClient(new WebViewClient());
		webView.setWebChromeClient(new WebChromeClient());
		//WebView.SetWebContentsDebuggingEnabled(true);
        //webView.loadUrl("file:///android_asset/index.html");
		//webView.loadUrl("http://polreslangkat.com:80");
		//webView.loadUrl("http://coffeepbb.com/index.php/home/pelayan");
		webView.loadUrl("http://192.168.43.138/lapas/virtual");


    }

	@Override
    public void onBackPressed() {
		WebView webView = (WebView) findViewById(R.id.webview);
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setCancelable(false);
        builder.setMessage("Do you want to Exit?");
        builder.setPositiveButton("Yes", new DialogInterface.OnClickListener() {
				@Override
				public void onClick(DialogInterface dialog, int which) {
					//if user pressed "yes", then he is allowed to exit from application
					finish();
				}
			});
        builder.setNegativeButton("No", new DialogInterface.OnClickListener() {
				@Override
				public void onClick(DialogInterface dialog, int which) {
					//if user select "No", just cancel this dialog and continue with app
					dialog.cancel();
					//ganti();
				}
			});
        AlertDialog alert = builder.create();
		//alert.show();

		if(webView.canGoBack()){
			webView.goBack();
		}
		else{
			alert.show();
		}
    }

	public class JavascriptToJava1 {
        @JavascriptInterface
        public void alert(String isi) {
            Toast.makeText(MainActivity.this, isi, Toast.LENGTH_SHORT).show();
			ganti();
        }
    }

	public void ganti(){
		WebView webView = (WebView) findViewById(R.id.webview);
		webView.loadUrl("file:///android_asset/tes.html");
	}

}
