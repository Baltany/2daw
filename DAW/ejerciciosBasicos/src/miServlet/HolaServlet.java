package miServlet;

import java.io.*;
import javax.Servlet.*;
import javax.servlet.http.*;

public class HolaServlet extends HttpServlet {
    public void doGet(HttpServletRequest request, HttpServletResponse response)
        throws ServletException, IOException {
        
        response.setContentType("text/html");
        PrintWriter out = response.getWriter();
        out.println("<html><body>");
        out.println("<h1>Hola desde el Servlet</h1>");
        out.println("</body></html>");
    }
}
