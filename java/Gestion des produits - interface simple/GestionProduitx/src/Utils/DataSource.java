/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Utils;

import java.sql.*;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author sanabenfadhel
 */
public class DataSource {

    private static DataSource data;
    private Connection con;
    private static String url = "jdbc:mysql://localhost:3306/alpha_fitness";
    private static String login = "root";
    private static String pwd = "";

    private DataSource() {
        try {
            con = DriverManager.getConnection(url, login, pwd);
        } catch (SQLException ex) {
            System.out.println(ex);
        }
    }

    public Connection getConnection() {
        return con;
    }

    public static DataSource getInstance() {
        if (data == null) {
            data = new DataSource();
        }
        return data;
    }
}
