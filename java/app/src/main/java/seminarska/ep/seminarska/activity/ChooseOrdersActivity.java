package seminarska.ep.seminarska.activity;

import android.content.Intent;
import android.os.Bundle;
import android.app.Activity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;

import seminarska.ep.seminarska.R;
import seminarska.ep.seminarska.utilities.Utils;

public class ChooseOrdersActivity extends Activity {

    private Button potrjeniBtn;
    private Button oddaniBtn;
    private Button storniraniBtn;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_choose_orders);

        potrjeniBtn = (Button) findViewById(R.id.potrjeni_btn);
        oddaniBtn = (Button) findViewById(R.id.oddani_btn);
        storniraniBtn = (Button) findViewById(R.id.stornirani_btn);

        potrjeniBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(ChooseOrdersActivity.this, OrdersActivity.class);
                intent.putExtra("tip", "potrjeni");
                startActivity(intent);
            }
        });

        oddaniBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(ChooseOrdersActivity.this, OrdersActivity.class);
                intent.putExtra("tip", "oddani");
                startActivity(intent);
            }
        });

        storniraniBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(ChooseOrdersActivity.this, OrdersActivity.class);
                intent.putExtra("tip", "stornirani");
                startActivity(intent);
            }
        });
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.odjava) {
            Utils.odjava(this);
        }

        return super.onOptionsItemSelected(item);
    }
}
