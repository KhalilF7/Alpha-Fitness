/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Test;

import Service.ServiceCategorie;
import Service.ServiceProduit;
import Service.ServiceProduit_Stock;

/**
 *
 * @author user
 */
public class Main {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        
        ServiceProduit sp = new ServiceProduit();
        //System.out.println(sp.getByNom("hhhhh").getImage().replaceAll("file:/C:/Users/user/Documents/NetBeansProjects/GestionProduitx/src/", "../"));
        
        /*ServiceCategorie sc = new ServiceCategorie();
        sc.modifier1(8, "aaa");
        
        ServiceProduit_Stock sps = new ServiceProduit_Stock();
        sps.afficher().forEach(System.out::println);*/
        
        sp.RechercheNom("Corde").forEach(System.out::println);
        System.out.println(sp.produitExist("aaa"));
    }
    
}
